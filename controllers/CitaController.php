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

    // GUARDAR O ACTUALIZAR CITA
    // GUARDAR O ACTUALIZAR CITA
    public function guardar() {
        $id         = $_POST['id'] ?? null;
        $pacienteId = $_POST['paciente_id'] ?? null;
        $fecha      = $_POST['fecha'] ?? null;
        $hora       = $_POST['hora'] ?? null;
        $estado     = $_POST['estado'] ?? 'pendiente';
        $motivo     = $_POST['motivo'] ?? '';

        if ($id) {
            // AL ACTUALIZAR: Se permite modificar la hora final enviada desde el formulario
            $horaFinal = $_POST['hora_final'] ?? null;

            $this->citaModel->update([
                'id'         => $id,
                'paciente_id'=> $pacienteId,
                'fecha'      => $fecha,
                'hora'       => $hora,
                'hora_final' => $horaFinal,
                'estado'     => $estado,
                'motivo'     => $motivo
            ]);
        } else {
            // AL CREAR: Por defecto calculamos 30 minutos más a la hora de inicio
            if ($hora) {
                $timestampInicio = strtotime($hora);
                $horaFinal       = date('H:i:s', strtotime('+30 minutes', $timestampInicio));
            } else {
                $horaFinal = null;
            }

            $this->citaModel->create([
                'paciente_id'=> $pacienteId,
                'fecha'      => $fecha,
                'hora'       => $hora,
                'hora_final' => $horaFinal, // Se guarda con los 30 minutos por defecto
                'estado'     => $estado,
                'motivo'     => $motivo
            ]);
        }

        header('Location: ' . BASE_URL . '/cita');
        exit();
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