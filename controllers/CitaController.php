<?php
require_once ROOT_PATH . '/models/Cita.php';
require_once ROOT_PATH . '/models/Paciente.php';

class CitaController
{
    private $citaModel;
    private $pacienteModel;

    public function __construct()
    {
        $this->citaModel = new Cita();
        $this->pacienteModel = new Paciente();
    }

    // LISTAR CITAS (Agenda principal)
    public function index()
    {
        requirePermission('citas');

        $usuarioId = $_SESSION['usuario_id'] ?? null;

        // Verificamos si el usuario puede ver toda la agenda.
        $tieneCitasTotal = hasPermission('citas_total');

        if ($tieneCitasTotal) {
            // Puede ver absolutamente todas las citas.
            $citas = $this->citaModel->getAll();

            // No necesita restricción de fechas.
            $fechasAtencion = [];
        } else {
            // Solo obtiene las fechas que tiene programadas.
            $fechasAtencion = $this->citaModel->getFechasAtencionDoctor($usuarioId);

            // Solo obtiene citas pertenecientes a esas fechas.
            $citas = $this->citaModel->getCitasPorFechasDoctor($usuarioId);
        }

        $pacientes = $this->pacienteModel->getAll();

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/citas/index.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // GUARDAR O ACTUALIZAR CITA
    // GUARDAR O ACTUALIZAR CITA
    public function guardar()
    {
        requirePermission('citas');

        $id = $_POST['id'] ?? null;
        $pacienteId = $_POST['paciente_id'] ?? null;
        $fecha = $_POST['fecha'] ?? null;
        $hora = $_POST['hora'] ?? null;
        $estado = $_POST['estado'] ?? 'pendiente';
        $motivo = $_POST['motivo'] ?? '';

        $usuarioId = $_SESSION['usuario_id'] ?? null;

        /*
    |--------------------------------------------------------------------------
    | VALIDAR FECHA PROGRAMADA
    |--------------------------------------------------------------------------
    */

        if (!hasPermission('citas_total')) {
            $usuarioId = isset($_SESSION['usuario_id']) ? (int) $_SESSION['usuario_id'] : 0;

            $fecha = isset($_POST['fecha']) ? trim((string) $_POST['fecha']) : '';

            // Validar que exista usuario y fecha
            if ($usuarioId <= 0 || empty($fecha)) {
                $_SESSION['error_acceso'] = 'No fue posible identificar el doctor o la fecha seleccionada.';

                header('Location: ' . BASE_URL . '/cita');
                exit();
            }

            // Validar formato real de fecha
            $fechaValidada = DateTime::createFromFormat('Y-m-d', $fecha);

            if (!$fechaValidada || $fechaValidada->format('Y-m-d') !== $fecha) {
                $_SESSION['error_acceso'] = 'La fecha seleccionada no es válida.';

                header('Location: ' . BASE_URL . '/cita');
                exit();
            }

            // Impedir citas en una fecha que pertenezca a otro doctor.
            if ($this->citaModel->fechaAsignadaAOtroDoctor($usuarioId, $fecha)) {
                $_SESSION['error_acceso'] = 'La fecha seleccionada ya está asignada a otro doctor.';

                header('Location: ' . BASE_URL . '/cita');
                exit();
            }

            // Comprobar que el doctor tenga ese día programado
            if (!$this->citaModel->fechaEstaProgramada($usuarioId, $fecha)) {
                $_SESSION['error_acceso'] = 'No tienes programada atención para la fecha seleccionada.';

                header('Location: ' . BASE_URL . '/cita');
                exit();
            }
        }

        /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR
    |--------------------------------------------------------------------------
    */

        if ($id) {
            $horaFinal = $_POST['hora_final'] ?? null;

            $this->citaModel->update([
                'id' => $id,
                'paciente_id' => $pacienteId,
                'fecha' => $fecha,
                'hora' => $hora,
                'hora_final' => $horaFinal,
                'estado' => $estado,
                'motivo' => $motivo,
            ]);
        } else {
            /*
        |--------------------------------------------------------------------------
        | CREAR
        |--------------------------------------------------------------------------
        */

            if ($hora) {
                $timestampInicio = strtotime($hora);

                $horaFinal = date('H:i:s', strtotime('+30 minutes', $timestampInicio));
            } else {
                $horaFinal = null;
            }

            $this->citaModel->create([
                'paciente_id' => $pacienteId,
                'fecha' => $fecha,
                'hora' => $hora,
                'hora_final' => $horaFinal,
                'estado' => $estado,
                'motivo' => $motivo,
            ]);
        }

        header('Location: ' . BASE_URL . '/cita');
        exit();
    }
    // CAMBIAR ESTADO (Atendida, Cancelada, etc.)
    public function cambiarEstado($id)
    {
        requirePermission('citas_editar');
        if (isset($_GET['estado'])) {
            $estado = $_GET['estado'];
            $this->citaModel->updateEstado($id, $estado);
        }
        header('Location: ' . BASE_URL . '/cita/index');
        exit();
    }

    // ELIMINAR CITA
    public function eliminar($id)
    {
        requirePermission('citas_eliminar');
        $this->citaModel->delete($id);
        header('Location: ' . BASE_URL . '/cita/index');
        exit();
    }
}
