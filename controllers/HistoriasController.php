<?php
require_once ROOT_PATH . '/helpers/auth.php';
require_once ROOT_PATH . '/models/Paciente.php';
require_once ROOT_PATH . '/models/HistoriaClinica.php'; // Se corrige la ruta al archivo existente

class HistoriasController {
    private $pacienteModel;
    private $historiaModel;
    private $db;

    public function __construct($db = null) {
        if ($db === null) {
            global $db;
        }

        $this->db = $db;

        // Instanciar modelos con la conexión PDO activa
        $this->pacienteModel = new Paciente($this->db);
        $this->historiaModel = new HistoriaClinica($this->db);
    }

    // Buscador / Lista de pacientes
    public function odontologia() {
        requirePermission('historia');
        $busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (!empty($busqueda)) {
            $pacientes = $this->pacienteModel->buscar($busqueda);
        } else {
            $pacientes = $this->pacienteModel->getAll();
        }

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/historias/odontologia_buscar.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // Cargar Historia Clínica, Odontograma y Convenciones del Paciente
    public function ver($id) {
        requirePermission('historia_ver');
        $paciente = $this->pacienteModel->getById($id);

        if (!$paciente) {
            header('Location: ' . BASE_URL . '/historias/odontologia');
            exit;
        }

        $stmtConv     = $this->db->query("SELECT * FROM convenciones WHERE activo = 1 ORDER BY id ASC");
        $convenciones = $stmtConv->fetchAll(PDO::FETCH_ASSOC);

        $historias = $this->historiaModel->getByPacienteId($id);

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/historias/ver.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // Guardar la consulta, el odontograma y la firma/acudiente
    // En HistoriasController.php -> modificar la función guardar()
    public function guardar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {$data = [
                'paciente_id'          => $id,
                'usuario_id'           => $_SESSION['usuario_id'] ?? null, // Trazabilidad del doctor
                'motivo_consulta'      => trim($_POST['motivo_consulta'] ?? ''),
                'diagnostico'          => trim($_POST['diagnostico'] ?? ''),
                'tratamiento'          => trim($_POST['tratamiento'] ?? ''),
                'observaciones'        => trim($_POST['observaciones'] ?? ''),
                'odontograma'          => $_POST['odontograma_data'] ?? '{}',
                'acudiente_nombre'     => !empty($_POST['acudiente_nombre']) ? trim($_POST['acudiente_nombre']) : null,
                'acudiente_documento'  => !empty($_POST['acudiente_documento']) ? trim($_POST['acudiente_documento']) : null,
                'acudiente_parentesco' => !empty($_POST['acudiente_parentesco']) ? trim($_POST['acudiente_parentesco']) : null,
                'firma_base64'         => !empty($_POST['firma_base64']) ?$_POST['firma_base64'] : null,
            ];

            $this->historiaModel->create($data);

            header('Location: ' . BASE_URL . '/historias/ver/' . $id);
            exit;
        }
    }
}
?>