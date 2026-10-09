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

        // citas_total permite agendar sin programar previamente un día.
        // El administrador conserva acceso completo; los demás no pueden usar
        // ni visualizar fechas que ya estén asignadas a otro doctor.
        $tieneCitasTotal = hasPermission('citas_total');
        $esAdministrador = $this->citaModel->usuarioEsAdministrador($usuarioId);
        $fechasBloqueadas = [];

        if ($tieneCitasTotal) {
            $citas = $this->citaModel->getAll();
            $fechasAtencion = [];

            if (!$esAdministrador) {
                $fechasOtrosDoctores = $this->citaModel->getFechasAtencionOtrosDoctores($usuarioId);
                foreach ($fechasOtrosDoctores as $fila) {
                    if (!empty($fila['fecha'])) {
                        $fechasBloqueadas[] = date('Y-m-d', strtotime($fila['fecha']));
                    }
                }

                // No mostrar en el listado citas que caigan en días de otro doctor.
                $citas = array_values(
                    array_filter($citas, function ($cita) use ($fechasBloqueadas) {
                        return !in_array(date('Y-m-d', strtotime($cita['fecha'])), $fechasBloqueadas, true);
                    }),
                );
            }
        } else {
            $fechasAtencion = $this->citaModel->getFechasAtencionDoctor($usuarioId);
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
    | VALIDAR FECHA DE LA CITA
    |--------------------------------------------------------------------------
    */
        $usuarioId = isset($_SESSION['usuario_id']) ? (int) $_SESSION['usuario_id'] : 0;
        $tieneCitasTotal = hasPermission('citas_total');
        $esAdministrador = $this->citaModel->usuarioEsAdministrador($usuarioId);
        $fecha = isset($_POST['fecha']) ? trim((string) $_POST['fecha']) : '';

        $fechaValidada = DateTime::createFromFormat('!Y-m-d', $fecha);
        if (!$fechaValidada || $fechaValidada->format('Y-m-d') !== $fecha) {
            $_SESSION['error_acceso'] = 'La fecha seleccionada no es válida.';
            header('Location: ' . BASE_URL . '/cita');
            exit();
        }

        // El domingo no es un día laboral: se bloquea para todos los usuarios.
        if ((int) $fechaValidada->format('N') === 7) {
            $_SESSION['error_acceso'] = 'No se pueden agendar citas los domingos. Selecciona un día de lunes a sábado.';
            header('Location: ' . BASE_URL . '/cita');
            exit();
        }

        // Solo admin puede usar una fecha que ya esté asignada a otro doctor.
        if (!$esAdministrador && $this->citaModel->fechaAsignadaAOtroDoctor($usuarioId, $fecha)) {
            $_SESSION['error_acceso'] = 'No puedes agendar ni consultar una fecha asignada a otro doctor.';
            header('Location: ' . BASE_URL . '/cita');
            exit();
        }

        // Sin citas_total, el usuario solo puede usar sus días programados.
        if (!$tieneCitasTotal && !$esAdministrador && !$this->citaModel->fechaEstaProgramada($usuarioId, $fecha)) {
            $_SESSION['error_acceso'] = 'No tienes programada atención para la fecha seleccionada.';
            header('Location: ' . BASE_URL . '/cita');
            exit();
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
