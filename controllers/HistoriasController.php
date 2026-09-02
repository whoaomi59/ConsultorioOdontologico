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

        // Obtener historia base y las consultas subsecuentes
        $historiaBase = $this->historiaModel->getBaseByPacienteId($id);


        $historias = $this->historiaModel->getByPacienteId($id);

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/historias/ver.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // Guardar únicamente la evolución, odontograma y firma de la nueva visita
    public function guardar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'paciente_id'     => $id,
                'usuario_id'      => $_SESSION['usuario_id'] ?? null,
                'motivo_consulta' => trim($_POST['motivo_consulta'] ?? ''),
                'diagnostico'     => trim($_POST['diagnostico'] ?? ''),
                'tratamiento'     => trim($_POST['tratamiento'] ?? ''),
                'observaciones'   => trim($_POST['observaciones'] ?? ''),
                'odontograma'     => $_POST['odontograma_data'] ?? '{}',
                'firma_base64'    => !empty($_POST['firma_base64']) ? $_POST['firma_base64'] : null,
            ];

            $this->historiaModel->create($data);

            header('Location: ' . BASE_URL . '/historias/ver/' . $id);
            exit;
        }
    }

    // Guardar o actualizar la Historia Base (Antecedentes e Higiene)
    public function guardarBase($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $estomatologico = isset($_POST['estomatologico']) ? json_encode($_POST['estomatologico'], JSON_UNESCAPED_UNICODE) : null;

            $data = [
                'paciente_id'             => $id,
                'alerta_medica'           => trim($_POST['alerta_medica'] ?? ''),
                'ant_hipertension'        => $_POST['ant_hipertension'] ?? null,
                'ant_traumas'             => $_POST['ant_traumas'] ?? null,
                'ant_cirugias'            => $_POST['ant_cirugias'] ?? null,
                'ant_hepatitis'           => $_POST['ant_hepatitis'] ?? null,
                'ant_convulsiones'        => $_POST['ant_convulsiones'] ?? null,
                'ant_alergias'            => $_POST['ant_alergias'] ?? null,
                'ant_hipoglicemia_diabetes'=> $_POST['ant_hipoglicemia_diabetes'] ?? null,
                'ant_gastritis_resp'      => $_POST['ant_gastritis_resp'] ?? null,
                'ant_t_mentales'          => $_POST['ant_t_mentales'] ?? null,
                'ant_enf_cardiovascular'  => $_POST['ant_enf_cardiovascular'] ?? null,
                'ant_cancer'              => $_POST['ant_cancer'] ?? null,
                'ant_embarazo'            => $_POST['ant_embarazo'] ?? null,
                'ant_fiebre_reumatica'    => $_POST['ant_fiebre_reumatica'] ?? null,
                'ant_sida'                => $_POST['ant_sida'] ?? null,
                'ant_otras'               => trim($_POST['ant_otras'] ?? ''),
                'higiene_cepillado'       => $_POST['higiene_cepillado'] ?? null,
                'higiene_cepillado_cant'  => trim($_POST['higiene_cepillado_cant'] ?? ''),
                'higiene_seda'            => $_POST['higiene_seda'] ?? null,
                'higiene_seda_cant'       => trim($_POST['higiene_seda_cant'] ?? ''),
                'higiene_enjuague'        => $_POST['higiene_enjuague'] ?? null,
                'higiene_enjuague_cant'   => trim($_POST['higiene_enjuague_cant'] ?? ''),
                'higiene_otro'            => $_POST['higiene_otro'] ?? null,
                'higiene_otro_cual'       => trim($_POST['higiene_otro_cual'] ?? ''),
                'examen_estomatologico'   => $estomatologico,
                'acudiente_nombre'        => trim($_POST['acudiente_nombre'] ?? ''),
                'acudiente_documento'     => trim($_POST['acudiente_documento'] ?? ''),
                'acudiente_parentesco'    => $_POST['acudiente_parentesco'] ?? null,
            ];

            $this->historiaModel->saveBase($data);
            header('Location: ' . BASE_URL . '/historias/ver/' . $id);
            exit;
        }
    }
}
?>