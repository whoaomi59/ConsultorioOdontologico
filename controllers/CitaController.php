<?php
require_once ROOT_PATH . '/models/Cita.php';
require_once ROOT_PATH . '/models/Paciente.php';

class CitaController {
    private $citaModel;
    private $pacienteModel;

    public function __construct() {
        $this->citaModel     = new Cita();
        $this->pacienteModel = new Paciente();
    }

    // LISTAR CITAS (Agenda principal)
    public function index() {
        requirePermission('citas');
        $citas     = $this->citaModel->getAll();
        $pacientes = $this->pacienteModel->getAll();

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/citas/index.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // GUARDAR NUEVA CITA
    public function guardar() {
        requirePermission('citas_crear');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'paciente_id' => $_POST['paciente_id'],
                'fecha'       => $_POST['fecha'],
                'hora'        => $_POST['hora'],
                'motivo'      => htmlspecialchars($_POST['motivo']),
                'estado'      => 'pendiente'
            ];

            $this->citaModel->create($data);
            header('Location: ' . BASE_URL . '/cita/index');
            exit;
        }
    }

    // CAMBIAR ESTADO (Atendida, Cancelada, etc.)
    public function cambiarEstado($id) {
        requirePermission('citas_editar');
        if (isset($_GET['estado'])) {
            $estado = $_GET['estado'];
            $this->citaModel->updateEstado($id, $estado);
        }
        header('Location: ' . BASE_URL . '/cita/index');
        exit;
    }

    // ELIMINAR CITA
    public function eliminar($id) {
        requirePermission('citas_eliminar');
        $this->citaModel->delete($id);
        header('Location: ' . BASE_URL . '/cita/index');
        exit;
    }
}