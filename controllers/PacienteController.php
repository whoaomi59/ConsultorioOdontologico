<?php
class PacienteController {
    private $pacienteModel;
    private $historiaModel;

    public function __construct() {
        requirePermission('pacientes');
        $this->pacienteModel = new Paciente();
        $this->historiaModel = new HistoriaClinica();
    }

    public function index() {
        $pacientes = $this->pacienteModel->getAll();
        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/pacientes/index.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    public function crear() {
        requirePermission('pacientes_crear');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Procesar foto de archivo o de cámara
            $fotoNombre = $this->uploadFoto($_FILES['foto'] ?? null, $_POST['foto_base64'] ?? null);

            $data = [
                'nombre'           => htmlspecialchars($_POST['nombre']),
                'apellido'         => htmlspecialchars($_POST['apellido']),
                'tipo_documento'   => htmlspecialchars($_POST['tipo_documento']),
                'documento'        => htmlspecialchars($_POST['documento']),
                'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                'telefono'         => htmlspecialchars($_POST['telefono']),
                'email'            => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
                'foto'             => $fotoNombre
            ];

            if ($this->pacienteModel->create($data)) {
                header('Location: ' . BASE_URL . '/paciente/index');
                exit;
            }
        }

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/pacientes/crear.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    public function editar($id) {
        requirePermission('pacientes_editar');
        $paciente = $this->pacienteModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Intentar subir nueva foto (archivo o base64)
            $nuevaFoto = $this->uploadFoto($_FILES['foto'] ?? null, $_POST['foto_base64'] ?? null);

            if ($nuevaFoto !== null) {
                // Borrar foto previa si existía
                if (!empty($paciente['foto'])) {
                    $fotoAntigua = rtrim(ROOT_PATH, '/\\') . '/public/uploads/pacientes/' . $paciente['foto'];
                    if (file_exists($fotoAntigua)) {
                        @unlink($fotoAntigua);
                    }
                }
                $fotoNombre = $nuevaFoto;
            } else {
                // Conservar la foto existente
                $fotoNombre = $paciente['foto'];
            }

            $data = [
                'id'               => $id,
                'nombre'           => htmlspecialchars($_POST['nombre']),
                'apellido'         => htmlspecialchars($_POST['apellido']),
                'tipo_documento'   => htmlspecialchars($_POST['tipo_documento']),
                'documento'        => htmlspecialchars($_POST['documento']),
                'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                'telefono'         => htmlspecialchars($_POST['telefono']),
                'email'            => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
                'foto'             => $fotoNombre
            ];

            $this->pacienteModel->update($data);
            header('Location: ' . BASE_URL . '/paciente/index');
            exit;
        }

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/pacientes/editar.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    public function historia($pacienteId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'paciente_id'     => $pacienteId,
                'motivo_consulta' => htmlspecialchars($_POST['motivo_consulta']),
                'diagnostico'     => htmlspecialchars($_POST['diagnostico']),
                'tratamiento'     => htmlspecialchars($_POST['tratamiento']),
                'observaciones'   => htmlspecialchars($_POST['observaciones']),
                'odontograma'     => $_POST['odontograma_data'] ?? null
            ];
            $this->historiaModel->create($data);
            header('Location: ' . BASE_URL . '/paciente/historia/' . $pacienteId);
            exit;
        }

        $paciente  = $this->pacienteModel->getById($pacienteId);
        $historias = $this->historiaModel->getByPacienteId($pacienteId);

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/historias/ver.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    public function perfil($id) {
        requirePermission('pacientes_perfil');
        $paciente = $this->pacienteModel->getById($id);
        if (!$paciente) {
            header('Location: ' . BASE_URL . '/paciente/index');
            exit;
        }

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/pacientes/perfil.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    public function eliminar($id) {
        requirePermission('pacientes_eliminar');
        $this->pacienteModel->delete($id);
        header('Location: ' . BASE_URL . '/paciente/index');
        exit;
    }

    // HELPER PARA GUARDAR IMAGEN (ARCHIVO O CÁMARA BASE64)
    private function uploadFoto($file, $base64 = null) {
        $directorio = rtrim(ROOT_PATH, '/\\') . '/public/uploads/pacientes/';

        if (!file_exists($directorio)) {
            if (!mkdir($directorio, 0777, true)) {
                error_log("Error al crear carpeta: " . $directorio);
                return null;
            }
        }

        // 1. Captura tomada con la cámara (Base64)
        if (!empty($base64) && strpos($base64, 'data:image') === 0) {
            if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
                $data = substr($base64, strpos($base64, ',') + 1);
                $ext  = strtolower($type[1]);
                if ($ext === 'jpeg') { $ext = 'jpg'; }
            } else {
                $data = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
                $ext  = 'jpg';
            }

            $data             = str_replace(' ', '+', $data);
            $dataDecodificada = base64_decode($data);

            if ($dataDecodificada !== false) {
                $nuevoNombre = uniqid('paciente_cam_') . '.' . $ext;
                if (file_put_contents($directorio . $nuevoNombre, $dataDecodificada) !== false) {
                    return $nuevoNombre;
                }
            }
        }

        // 2. Archivo subido tradicionalmente
        if ($file && isset($file['error']) && $file['error'] === UPLOAD_ERR_OK) {
            $ext        = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($ext, $permitidas)) {
                $nuevoNombre = uniqid('paciente_') . '.' . $ext;
                if (move_uploaded_file($file['tmp_name'], $directorio . $nuevoNombre)) {
                    return $nuevoNombre;
                }
            }
        }

        return null;
    }
}