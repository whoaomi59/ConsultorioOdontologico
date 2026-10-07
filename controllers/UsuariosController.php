<?php

require_once ROOT_PATH . '/helpers/auth.php';
require_once ROOT_PATH . '/models/Usuario.php';
require_once ROOT_PATH . '/models/Cita.php';

class UsuariosController {
    private $usuarioModel;
    private $citaModel;
    private $db;

    public function __construct($db = null) {
        if ($db === null) {
            global $db;
        }

        $this->db = $db;

        $this->usuarioModel = new Usuario($this->db);
        $this->citaModel    = new Cita($this->db);
    }


    /* =========================================================
       LISTADO DE USUARIOS
    ========================================================= */

    public function index() {
        requirePermission('usuarios');

        $usuarios = $this->usuarioModel->getAll();

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/usuarios/index.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }


    /* =========================================================
       CREAR USUARIO
    ========================================================= */

    public function crear() {
        requirePermission('usuarios_crear');

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/usuarios/crear.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }


    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $fotoNombre = $this->uploadFoto(
            $_FILES['foto'] ?? null,
            $_POST['foto_base64'] ?? null
            );

            $id = $this->usuarioModel->create([
                'nombre' => trim($_POST['nombre']),
                'email'  => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'rol'    => $_POST['rol'],
                'foto'   => $fotoNombre
            ]);

            if ($id && isset($_POST['modulos'])) {
                $this->usuarioModel->syncPermisos(
                $id,
                $_POST['modulos']
                );
            }

            header(
            'Location: ' .
            BASE_URL .
            '/usuarios/index'
            );

            exit;
        }
    }


    /* =========================================================
       VER PERFIL ADMINISTRATIVO
    ========================================================= */

    public function ver($id) {
        requirePermission('usuarios_ver');

        $usuario  = $this->usuarioModel->getById($id);
        $permisos = $this->usuarioModel->getPermisos($id);

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/usuarios/ver.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }


    /* =========================================================
       EDITAR USUARIO ADMINISTRATIVO
    ========================================================= */

    public function editar($id) {
        requirePermission('usuarios_editar');

        $usuario  = $this->usuarioModel->getById($id);
        $permisos = $this->usuarioModel->getPermisos($id);

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/usuarios/editar.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }


    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuarioActual =
            $this->usuarioModel->getById($id);

            $fotoNombre = $this->uploadFoto(
            $_FILES['foto'] ?? null,
            $_POST['foto_base64'] ?? null
            );

            if ($fotoNombre === null) {

                $fotoNombre =
                $usuarioActual['foto'] ?? null;

            } else {

                if (!empty($usuarioActual['foto'])) {

                    $fotoAntigua =
                    rtrim(ROOT_PATH, '/\\') .
                    '/public/uploads/usuarios/' .
                    $usuarioActual['foto'];

                    if (file_exists($fotoAntigua)) {
                        @unlink($fotoAntigua);
                    }
                }
            }

            $this->usuarioModel->update($id, [

                'nombre' =>
                trim($_POST['nombre']),

                'email' =>
                trim($_POST['email']),

                'password' =>
                trim($_POST['password'] ?? ''),

                'rol' =>
                $_POST['rol'],

                'estado' =>
                isset($_POST['estado']) ? 1 : 0,

                'foto' =>
                $fotoNombre,

                'firma_base64' =>
                !empty($_POST['firma_base64'])
                ? $_POST['firma_base64']
                : null
            ]);

            $modulos =
            $_POST['modulos'] ?? [];

            $this->usuarioModel
            ->syncPermisos($id, $modulos);

            header(
            'Location: ' .
            BASE_URL .
            '/usuarios/index'
            );

            exit;
        }
    }


    /* =========================================================
       MI PERFIL
    ========================================================= */

    public function miPerfil() {
        if (empty($_SESSION['usuario_id'])) {
            header(
            'Location: ' .
            BASE_URL .
            '/login'
            );
            exit;
        }

        $usuarioId =
        (int) $_SESSION['usuario_id'];

        $usuario =
        $this->usuarioModel
        ->getById($usuarioId);

        if (!$usuario) {
            http_response_code(404);
            echo 'Usuario no encontrado.';
            exit;
        }

        $fechasAtencion =
        $this->usuarioModel
        ->getFechasAtencion($usuarioId);

        /*
         * Obtenemos las citas correspondientes
         * a las fechas programadas del doctor.
         */
        $citas =
        $this->citaModel
        ->getCitasPorFechasDoctor($usuarioId);

        $totalCitas = count($citas);

        $pendientes = 0;
        $atendidas  = 0;
        $canceladas = 0;

        foreach ($citas as $cita) {

            $estado =
            strtolower(
            trim(
            $cita['estado'] ?? ''
            )
            );

            if ($estado === 'pendiente') {
                $pendientes++;
            }

            if (
            $estado === 'atendida' ||
            $estado === 'atendido'
            ) {
                $atendidas++;
            }

            if (
            $estado === 'cancelada' ||
            $estado === 'cancelado'
            ) {
                $canceladas++;
            }
        }

        /*
         * Fechas históricas que ya pasaron.
         */
        $diasAtendidos = 0;

        foreach ($fechasAtencion as $fecha) {

            if (
            !empty($fecha['fecha']) &&
            $fecha['fecha'] < date('Y-m-d')
            ) {
                $diasAtendidos++;
            }
        }

        $estadisticas = [
            'dias_programados' => count($fechasAtencion),
            'dias_realizados'  => $diasAtendidos,
            'total_citas'      => $totalCitas,
            'pendientes'       => $pendientes,
            'atendidas'        => $atendidas,
            'canceladas'       => $canceladas
        ];

        require_once ROOT_PATH .
        '/views/layout/header.php';

        require_once ROOT_PATH .
        '/views/usuarios/miPerfil.php';

        require_once ROOT_PATH .
        '/views/layout/footer.php';
    }


    /* =========================================================
       ACTUALIZAR MI PERFIL
    ========================================================= */

    public function actualizarMiPerfil() {
        if (
        empty($_SESSION['usuario_id']) ||
        $_SERVER['REQUEST_METHOD'] !== 'POST'
        ) {
            header(
            'Location: ' .
            BASE_URL .
            '/usuarios/miPerfil'
            );
            exit;
        }

        $usuarioId =
        (int) $_SESSION['usuario_id'];

        $usuarioActual =
        $this->usuarioModel
        ->getById($usuarioId);

        if (!$usuarioActual) {
            header(
            'Location: ' .
            BASE_URL .
            '/usuarios/miPerfil'
            );
            exit;
        }

        $fotoNombre =
        $this->uploadFoto(
        $_FILES['foto'] ?? null,
        $_POST['foto_base64'] ?? null
        );

        if ($fotoNombre === null) {

            $fotoNombre =
            $usuarioActual['foto'] ?? null;

        } else {

            if (!empty($usuarioActual['foto'])) {

                $fotoAntigua =
                rtrim(ROOT_PATH, '/\\') .
                '/public/uploads/usuarios/' .
                $usuarioActual['foto'];

                if (file_exists($fotoAntigua)) {
                    @unlink($fotoAntigua);
                }
            }
        }

        $this->usuarioModel->update(
        $usuarioId,
        [
            'nombre' =>
            trim($_POST['nombre']),

            'email' =>
            trim($_POST['email']),

            'password' =>
            trim($_POST['password'] ?? ''),

        /*
                 * El usuario NO puede cambiar su rol
                 * desde su perfil personal.
                 */
            'rol' =>
            $usuarioActual['rol'],

            'estado' =>
            $usuarioActual['estado'],

            'foto' =>
            $fotoNombre
        ]
        );

        $_SESSION['usuario_nombre'] =
        trim($_POST['nombre']);

        header(
        'Location: ' .
        BASE_URL .
        '/usuarios/miPerfil'
        );

        exit;
    }


    /* =========================================================
       AGREGAR FECHA DE ATENCIÓN
    ========================================================= */

    public function guardarFechaAtencion() {
        if (
        empty($_SESSION['usuario_id']) ||
        $_SERVER['REQUEST_METHOD'] !== 'POST'
        ) {
            header(
            'Location: ' .
            BASE_URL .
            '/usuarios/miPerfil'
            );
            exit;
        }

        $usuarioId =
        (int) $_SESSION['usuario_id'];

        $usuario =
        $this->usuarioModel
        ->getById($usuarioId);

        /*
         * Solamente doctores pueden
         * programar sus fechas.
         */
        if (
        !$usuario ||
        ($usuario['rol'] ?? '') !== 'doctor'
        ) {
            $_SESSION['error_perfil'] =
            'Solo los doctores pueden programar fechas de atención.';

            header(
            'Location: ' .
            BASE_URL .
            '/usuarios/miPerfil'
            );
            exit;
        }

        $fecha =
        $_POST['fecha'] ?? '';

        $hora =
        $_POST['hora_inicio'] ?? '';

        if ($fecha === '' || $hora === '') {

            $_SESSION['error_perfil'] =
            'Debes seleccionar una fecha y una hora.';

            header(
            'Location: ' .
            BASE_URL .
            '/usuarios/miPerfil'
            );
            exit;
        }

        /*
         * No permitimos fechas anteriores
         * al día actual.
         */
        if ($fecha < date('Y-m-d')) {

            $_SESSION['error_perfil'] =
            'No puedes programar una fecha anterior a hoy.';

            header(
            'Location: ' .
            BASE_URL .
            '/usuarios/miPerfil'
            );
            exit;
        }

        /*
         * Evitamos duplicados.
         */
        $existe =
        $this->usuarioModel
        ->fechaAtencionExiste(
        $usuarioId,
        $fecha,
        $hora
        );

        if ($existe) {

            $_SESSION['error_perfil'] =
            'Ya tienes esa fecha y hora programadas.';

            header(
            'Location: ' .
            BASE_URL .
            '/usuarios/miPerfil'
            );
            exit;
        }

        $guardado =
        $this->usuarioModel
        ->crearFechaAtencion(
        $usuarioId,
        $fecha,
        $hora
        );

        if ($guardado) {

            $_SESSION['exito_perfil'] =
            'Fecha de atención programada correctamente.';

        } else {

            $_SESSION['error_perfil'] =
            'No fue posible guardar la fecha.';
        }

        header(
        'Location: ' .
        BASE_URL .
        '/usuarios/miPerfil'
        );

        exit;
    }


    /* =========================================================
       ELIMINAR FECHA DE ATENCIÓN
    ========================================================= */

    public function eliminarFechaAtencion($id) {
        if (empty($_SESSION['usuario_id'])) {
            header(
            'Location: ' .
            BASE_URL .
            '/login'
            );
            exit;
        }

        $usuarioId =
        (int) $_SESSION['usuario_id'];

        $id =
        (int) $id;

        /*
         * El modelo verifica nuevamente
         * que la fecha pertenezca al usuario.
         */
        $fecha =
        $this->usuarioModel
        ->getFechaAtencionById(
        $id,
        $usuarioId
        );

        if (!$fecha) {

            $_SESSION['error_perfil'] =
            'No puedes eliminar esta fecha.';

            header(
            'Location: ' .
            BASE_URL .
            '/usuarios/miPerfil'
            );
            exit;
        }

        if ($fecha['fecha'] < date('Y-m-d')) {

            $_SESSION['error_perfil'] =
            'No puedes eliminar una fecha que ya pasó.';

            header(
            'Location: ' .
            BASE_URL .
            '/usuarios/miPerfil'
            );
            exit;
        }

        $eliminado =
        $this->usuarioModel
        ->eliminarFechaAtencion(
        $id,
        $usuarioId
        );

        if ($eliminado) {

            $_SESSION['exito_perfil'] =
            'Fecha eliminada correctamente.';

        } else {

            $_SESSION['error_perfil'] =
            'No fue posible eliminar la fecha.';
        }

        header(
        'Location: ' .
        BASE_URL .
        '/usuarios/miPerfil'
        );

        exit;
    }


    /* =========================================================
       ELIMINAR USUARIO
    ========================================================= */

    public function eliminar($id) {
        requirePermission('usuarios_eliminar');

        $this->usuarioModel->delete($id);

        header(
        'Location: ' .
        BASE_URL .
        '/usuarios/index'
        );

        exit;
    }


    /* =========================================================
       SUBIR FOTO
    ========================================================= */

    private function uploadFoto($file, $base64 = null) {
        $directorio =
        ROOT_PATH .
        '/public/uploads/usuarios/';

        if (!file_exists($directorio)) {
            mkdir(
            $directorio,
            0777,
            true
            );
        }

        /*
         * FOTO DESDE CÁMARA
         */
        if (
        !empty($base64) &&
        strpos(
        $base64,
        'data:image'
        ) === 0
        ) {

            $partes =
            explode(
            ',',
            $base64,
            2
            );

            if (count($partes) === 2) {

                $datos =
                base64_decode(
                $partes[1]
                );

                if ($datos !== false) {

                    $nombre =
                    'usuario_' .
                    uniqid('', true) .
                    '.jpg';

                    $ruta =
                    $directorio .
                    $nombre;

                    if (
                    file_put_contents(
                    $ruta,
                    $datos
                    )
                    ) {
                        return $nombre;
                    }
                }
            }
        }

        /*
         * FOTO DESDE ARCHIVO
         */
        if (
        isset($file) &&
        isset($file['error']) &&
        $file['error'] === UPLOAD_ERR_OK
        ) {

            $extension =
            strtolower(
            pathinfo(
            $file['name'],
            PATHINFO_EXTENSION
            )
            );

            $permitidas = [
                'jpg',
                'jpeg',
                'png',
                'webp'
            ];

            if (
            !in_array(
                $extension,
                $permitidas,
                true
            )
            ) {
                return null;
            }

            $nombre =
            'usuario_' .
            uniqid('', true) .
            '.' .
            $extension;

            $ruta =
            $directorio .
            $nombre;

            if (
            move_uploaded_file(
            $file['tmp_name'],
            $ruta
            )
            ) {
                return $nombre;
            }
        }

        return null;
    }
}