<?php
require_once ROOT_PATH . '/helpers/auth.php';
require_once ROOT_PATH . '/models/Paciente.php';
require_once ROOT_PATH . '/models/HistoriaOrtodoncia.php';
require_once ROOT_PATH . '/models/Consultorio.php';


class OrtodonciaController {
    private $pacienteModel;
    private $ortodonciaModel;
    private $consultorioModel; // <--- Declarada aquí para evitar el aviso (deprecated)
    private $db;

    public function __construct($db = null) {
        if ($db === null) { global $db; }
        $this->db               = $db;
        $this->pacienteModel    = new Paciente($this->db);
        $this->ortodonciaModel  = new HistoriaOrtodoncia($this->db);
        $this->consultorioModel = new Consultorio($this->db);
    }
    // Buscador / Lista de pacientes
    public function ortodoncia() {
        $busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (!empty($busqueda)) {
            $pacientes = $this->pacienteModel->buscar($busqueda);
        } else {
            $pacientes = $this->pacienteModel->getAll();
        }

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/ortodoncia/ortodoncia_buscar.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    public function ver($pacienteId) {
        requirePermission('historia_ortodoncia');

        $paciente = $this->pacienteModel->getById($pacienteId);
        if (!$paciente) {
            header('Location: ' . BASE_URL . '/paciente/index');
            exit;
        }

        $historia    = $this->ortodonciaModel->getByPacienteId($pacienteId);
        $evoluciones = $historia ? $this->ortodonciaModel->getEvolucionesByHistoriaId($historia['id']) : [];
        $consultorio = $this->consultorioModel->getInfo();
        $modoEdicion = isset($_GET['modo']) && $_GET['modo'] === 'editar';

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/ortodoncia/ver.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    public function guardarDiagnostico($pacienteId) {
        requirePermission('historia_ortodoncia');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->prepararDatosDiagnostico($_POST, $pacienteId);

            $this->ortodonciaModel->createDiagnostico($data);
            header('Location: ' . BASE_URL . '/ortodoncia/ver/' . $pacienteId);
            exit;
        }
    }

    public function editarDiagnostico($pacienteId) {
        requirePermission('historia_ortodoncia');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data       = $this->prepararDatosDiagnostico($_POST, $pacienteId);
            $historiaId = $_POST['historia_id'] ?? null;

            if ($historiaId) {
                $this->ortodonciaModel->updateDiagnostico($historiaId, $data);
            }

            header('Location: ' . BASE_URL . '/ortodoncia/ver/' . $pacienteId);
            exit;
        }
    }

    public function guardarEvolucion($pacienteId) {
        requirePermission('historia_ortodoncia');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $historiaId = $_POST['historia_id'] ?? null;
            if ($historiaId) {
                $rutaPdf = null;

                // Procesar subida de PDF de Radiografía
                if (isset($_FILES['radiografia_pdf']) && $_FILES['radiografia_pdf']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath   = $_FILES['radiografia_pdf']['tmp_name'];
                    $fileName      = $_FILES['radiografia_pdf']['name'];
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    if ($fileExtension === 'pdf') {
                        $uploadDir = ROOT_PATH . '/public/uploads/radiografias/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }

                        $newFileName = 'radio_' . $historiaId . '_' . time() . '.pdf';
                        $dest_path   = $uploadDir . $newFileName;

                        if (move_uploaded_file($fileTmpPath, $dest_path)) {
                            $rutaPdf = 'public/uploads/radiografias/' . $newFileName;
                        }
                    }
                }

                $data = [
                    'historia_id'           => $historiaId,
                    'usuario_id'            => $_SESSION['usuario_id'] ?? null,
                    'descripcion_evolucion' => htmlspecialchars($_POST['descripcion_evolucion'] ?? ''),
                    'valor_evolucion'       => isset($_POST['valor_evolucion']) ? (float)$_POST['valor_evolucion'] : 0.00,
                    'radiografia_pdf'       => $rutaPdf,
                    'firma_paciente_base64' => !empty($_POST['firma_paciente_base64']) ? $_POST['firma_paciente_base64'] : null
                ];

                $this->ortodonciaModel->createEvolucion($data);
            }
            header('Location: ' . BASE_URL . '/ortodoncia/ver/' . $pacienteId);
            exit;
        }
    }

    private function prepararDatosDiagnostico($post, $pacienteId) {
        $data                = $post;
        $data['paciente_id'] = $pacienteId;
        $data['usuario_id']  = $_SESSION['usuario_id'] ?? null;

        // Mapeo exacto de los checkboxes múltiples de la vista a las columnas DB
        $data['periodonto_disminuido_dientes']         = !empty($post['periodonto_dientes']) && is_array($post['periodonto_dientes']) ? implode(',', $post['periodonto_dientes']) : null;
        $data['dientes_retenidos_dientes']             = !empty($post['retenidos_dientes']) && is_array($post['retenidos_dientes']) ? implode(',', $post['retenidos_dientes']) : null;
        $data['dientes_supernumerarios_dientes']       = !empty($post['supernumerarios_dientes']) && is_array($post['supernumerarios_dientes']) ? implode(',', $post['supernumerarios_dientes']) : null;
        $data['longitud_radicular_disminuida_dientes'] = !empty($post['longitud_dientes']) && is_array($post['longitud_dientes']) ? implode(',', $post['longitud_dientes']) : null;

        // Eliminar las variables temporales enviadas por la vista que no existen como columnas DB
        unset($data['periodonto_dientes'], $data['retenidos_dientes'], $data['supernumerarios_dientes'], $data['longitud_dientes']);

        // Añadir en el array $checkboxes dentro de prepararDatosDiagnostico():
        $checkboxes = [
            'frenillo_sobreinsertado_sup', 'frenillo_sobreinsertado_inf',
            'frenillo_sobreinsertado_lat', 'frenillo_sobreinsertado_lin', 'habito_onicofagia',
            'habito_respiracion_oral', 'habito_succion_digital', 'habito_succion_labial', 'habito_presion',
            'habito_alternacion_foniatricas', 'deglucion_empuje_lingual_simple', 'deglucion_empuje_lingual_complejo',
            'deglucion_infantil', 'bruxismo_diurno', 'bruxismo_nocturno', 'ruido_cliking', 'ruido_crepitacion',
            'dolor_muscular_presente', 'periodonto_disminuido', 'dientes_retenidos_impactados',
            'dientes_supernumerarios', 'longitud_radicular_disminuida',
            // Nuevos campos de mordidas cruzadas/abiertas
            'mordida_cruzada_posterior_der', 'mordida_cruzada_posterior_izq',
            'mordida_cruzada_anterior', 'mordida_abierta_anterior', 'mordida_abierta_posterior'
        ];

        foreach ($checkboxes as $cb) {
            $data[$cb] = isset($post[$cb]) ? 1 : 0;
        }

        if (isset($post['tratamiento_previo_ortodoncia'])) {
            $data['tratamiento_previo_ortodoncia'] = (int)$post['tratamiento_previo_ortodoncia'];
        }

        $campos_decimales = [
            'medida_apertura_maxima_mm',
            'medida_lateralidad_derecha_mm',
            'medida_lateralidad_izquierda_mm',
            'desviacion_mandibular_mm'
        ];

        foreach ($campos_decimales as $campo) {
            if (!isset($data[$campo]) || trim((string)$data[$campo]) === '') {
                $data[$campo] = null;
            } else {
                $data[$campo] = (float)str_replace(',', '.', $data[$campo]);
            }
        }

        foreach ($data as $key => $value) {
            if (is_string($value) && trim($value) === '') {
                $data[$key] = null;
            }
        }

        return $data;
    }
}