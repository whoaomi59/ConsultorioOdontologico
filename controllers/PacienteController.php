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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fotoNombre = null;

            // Procesar la foto opcional
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $ext                   = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
                $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

                if (in_array($ext, $extensionesPermitidas)) {
                    // Genera un nombre único para evitar sobreescribir imágenes
                    $fotoNombre        = uniqid('paciente_', true) . '.' . $ext;
                    $directorioDestino = ROOT_PATH . '/public/uploads/pacientes/';

                    // Crear la carpeta si aún no existe
                    if (!file_exists($directorioDestino)) {
                        mkdir($directorioDestino, 0777, true);
                    }

                    move_uploaded_file($_FILES['foto']['tmp_name'], $directorioDestino . $fotoNombre);
                }
            }

            $data = [
                'nombre'         => htmlspecialchars($_POST['nombre']),
                'apellido'       => htmlspecialchars($_POST['apellido']),
                'tipo_documento' => htmlspecialchars($_POST['tipo_documento']), // Campo agregado
                'documento'      => htmlspecialchars($_POST['documento']),
                'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                'telefono'       => htmlspecialchars($_POST['telefono']),
                'email'          => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
                'foto'           => $fotoNombre
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

    public function historia($pacienteId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'paciente_id' => $pacienteId,
                'motivo_consulta' => htmlspecialchars($_POST['motivo_consulta']),
                'diagnostico' => htmlspecialchars($_POST['diagnostico']),
                'tratamiento' => htmlspecialchars($_POST['tratamiento']),
                'observaciones' => htmlspecialchars($_POST['observaciones']),
                'odontograma' => $_POST['odontograma_data'] ?? null
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
        $paciente = $this->pacienteModel->getById($id);
        if (!$paciente) {
            header('Location: ' . BASE_URL . '/paciente/index');
            exit;
        }

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/pacientes/perfil.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    public function editar($id) {
        $paciente = $this->pacienteModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fotoNombre = $paciente['foto'];

            // Si se sube una nueva foto
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $ext        = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
                $fotoNombre = uniqid('paciente_', true) . '.' . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], ROOT_PATH . '/public/uploads/pacientes/' . $fotoNombre);
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

    public function eliminar($id) {
        $this->pacienteModel->delete($id);
        header('Location: ' . BASE_URL . '/paciente/index');
        exit;
    }
}