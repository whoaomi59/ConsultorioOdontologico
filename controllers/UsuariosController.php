<?php
require_once ROOT_PATH . '/helpers/auth.php';
require_once ROOT_PATH . '/models/Usuario.php';

class UsuariosController {
    private $usuarioModel;
    private $db;

    public function __construct($db = null) {
        if ($db === null) { global$db; }
        $this->db           = $db;
        $this->usuarioModel = new Usuario($this->db);
    }

    // LISTAR USUARIOS (Vista Principal)
    public function index() {
        //requireRole(['admin']);
        $usuarios = $this->usuarioModel->getAll();

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/usuarios/index.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // FORMULARIO: REGISTRAR
    public function crear() {
        // requireRole(['admin']);
        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/usuarios/crear.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // GUARDAR NUEVO
    public function guardar() {
        //requireRole(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Procesar foto de archivo o cámara
            $fotoNombre = $this->uploadFoto($_FILES['foto'] ?? null, $_POST['foto_base64'] ?? null);

            $id = $this->usuarioModel->create([
                'nombre'   => trim($_POST['nombre']),
                'email'    => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'rol'      => $_POST['rol'],
                'foto'     => $fotoNombre
            ]);

            if ($id && isset($_POST['modulos'])) {
                $this->usuarioModel->syncPermisos($id, $_POST['modulos']);
            }

            header('Location: ' . BASE_URL . '/usuarios/index');
            exit;
        }
    }

    // VER PERFIL
    public function ver($id) {
        //requireRole(['admin']);
        $usuario = $this->usuarioModel->getById($id);$permisos = $this->usuarioModel->getPermisos($id);

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/usuarios/ver.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // FORMULARIO: EDITAR USUARIO
    public function editar($id) {
        //requireRole(['admin']);
        $usuario = $this->usuarioModel->getById($id);$permisos = $this->usuarioModel->getPermisos($id);

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/usuarios/editar.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // ACTUALIZAR USUARIO Y PERMISOS
    public function actualizar($id) {
        // requireRole(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {$fotoNombre = $this->uploadFoto($_FILES['foto'] ?? null);

            $this->usuarioModel->update($id, [
                'nombre'   => trim($_POST['nombre']),
                'email'    => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'rol'      => $_POST['rol'],
                'estado'   => isset($_POST['estado']) ? 1 : 0,                 'foto'     =>$fotoNombre
            ]);

            $modulos = $_POST['modulos'] ?? [];$this->usuarioModel->syncPermisos($id,$modulos);

            header('Location: ' . BASE_URL . '/usuarios/index');
            exit;
        }
    }

    // ELIMINAR USUARIO
    public function eliminar($id) {
        //requireRole(['admin']);
        $this->usuarioModel->delete($id);
        header('Location: ' . BASE_URL . '/usuarios/index');
        exit;
    }

    // HELPER PARA GUARDAR IMAGEN (FILE O BASE64)
    private function uploadFoto($file, $base64 = null) {
        $directorio = ROOT_PATH . '/public/uploads/usuarios/';
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // 1. Si la foto proviene de la Captura de la Cámara (Base64)
        if (!empty($base64) && preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
            $data = substr($base64, strpos($base64, ',') + 1);
            $data = base64_decode($data);

            $nuevoNombre = uniqid('cam_') . '.jpg';
            if (file_put_contents($directorio . $nuevoNombre, $data)) {
                return $nuevoNombre;
            }
        }

        // 2. Si proviene de la carga tradicional de archivo
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $ext        = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($ext, $permitidas)) {
                $nuevoNombre = uniqid('user_') . '.' . $ext;
                if (move_uploaded_file($file['tmp_name'], $directorio . $nuevoNombre)) {
                    return $nuevoNombre;
                }
            }
        }

        return null;
    }
}
?>