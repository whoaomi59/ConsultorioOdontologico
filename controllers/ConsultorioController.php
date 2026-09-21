<?php
require_once ROOT_PATH . '/helpers/auth.php';
require_once ROOT_PATH . '/models/Consultorio.php';

class ConsultorioController {
    private $consultorioModel;
    private $db;

    public function __construct($db = null) {
        if ($db === null) { global $db; }
        $this->db               = $db;
        $this->consultorioModel = new Consultorio($this->db);
    }

    // Mostrar el formulario con los datos y las convenciones
    public function index() {
        requirePermission('configuracion');

        $consultorio  = $this->consultorioModel->getInfo();
        $convenciones = $this->consultorioModel->getConvenciones();

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/consultorio/index.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // Guardar consultorio y sincronizar convenciones (Insertar, Actualizar, Eliminar)
    public function guardar() {
        requirePermission('configuracion');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre          = trim($_POST['nombre'] ?? '');
            $direccion       = trim($_POST['direccion'] ?? '');
            $logoPath        = $_POST['logo_actual'] ?? '';
            $convencionesEnv = $_POST['convenciones'] ?? [];

            // Procesar la subida del logotipo si se adjuntó uno nuevo
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath   = $_FILES['logo']['tmp_name'];
                $fileName      = $_FILES['logo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($fileExtension, $allowedExtensions)) {
                    $uploadRelativeDir = 'public/uploads/consultorio/';
                    $uploadAbsoluteDir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/ConsultorioOdontologico/' . $uploadRelativeDir;

                    if (!is_dir($uploadAbsoluteDir)) {
                        mkdir($uploadAbsoluteDir, 0755, true);
                    }

                    $newFileName = 'logo_consultorio_' . time() . '.' . $fileExtension;
                    $destPath    = $uploadAbsoluteDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $logoPath = $uploadRelativeDir . $newFileName;
                    }
                }
            }

            try {
                $this->db->beginTransaction();

                // 1. Guardar o actualizar información general del consultorio
                $infoActual = $this->consultorioModel->getInfo();
                if ($infoActual) {
                    $query = "UPDATE consultorio SET Nombre = :nombre, direccion = :direccion, Logo = :logo WHERE ID = :id";
                    $stmt  = $this->db->prepare($query);
                    $stmt->execute([
                        'nombre'    => $nombre,
                        'direccion' => $direccion,
                        'logo'      => $logoPath,
                        'id'        => $infoActual['ID']
                    ]);
                } else {
                    $query = "INSERT INTO consultorio (Nombre, direccion, Logo) VALUES (:nombre, :direccion, :logo)";
                    $stmt  = $this->db->prepare($query);
                    $stmt->execute([
                        'nombre'    => $nombre,
                        'direccion' => $direccion,
                        'logo'      => $logoPath
                    ]);
                }

                // 2. Sincronizar Convenciones (IDs enviados vs IDs actuales en BD para eliminar los removidos)
                $idsEnviados = [];
                foreach ($convencionesEnv as $conv) {
                    if (!empty($conv['id'])) {
                        $idsEnviados[] = (int)$conv['id'];
                    }
                }

                // Obtener convenciones existentes para limpiar las que el usuario borró de la interfaz
                $actuales     = $this->consultorioModel->getConvenciones();
                $idsActuales  = array_column($actuales, 'id');
                $idsAEliminar = array_diff($idsActuales, $idsEnviados);

                if (!empty($idsAEliminar)) {
                    $placeholders = implode(',', array_fill(0, count($idsAEliminar), '?'));
                    $stmtDel      = $this->db->prepare("DELETE FROM convenciones WHERE id IN ($placeholders)");
                    $stmtDel->execute(array_values($idsAEliminar));
                }

                // Insertar o Actualizar cada convención enviada
                foreach ($convencionesEnv as $conv) {
                    $id          = !empty($conv['id']) ? (int)$conv['id'] : null;
                    $convNombre  = trim($conv['nombre'] ?? '');
                    $codigo      = trim($conv['codigo'] ?? '');
                    $color       = !empty($conv['color_text']) ? trim($conv['color_text']) : (trim($conv['color'] ?? '#3b82f6'));
                    $descripcion = trim($conv['descripcion'] ?? '');
                    $activo      = 1;

                    if ($convNombre === '' || $codigo === '') continue;

                    if ($id) {
                        // Actualizar existente
                        $sqlConv  = "UPDATE convenciones SET nombre = :nombre, codigo = :codigo, color = :color, descripcion = :descripcion WHERE id = :id";
                        $stmtConv = $this->db->prepare($sqlConv);
                        $stmtConv->execute([
                            'nombre'      => $convNombre,
                            'codigo'      => $codigo,
                            'color'       => $color,
                            'descripcion' => $descripcion,
                            'id'          => $id
                        ]);
                    } else {
                        // Insertar nueva
                        $sqlConv  = "INSERT INTO convenciones (nombre, codigo, color, descripcion, activo) VALUES (:nombre, :codigo, :color, :descripcion, :activo)";
                        $stmtConv = $this->db->prepare($sqlConv);
                        $stmtConv->execute([
                            'nombre'      => $convNombre,
                            'codigo'      => $codigo,
                            'color'       => $color,
                            'descripcion' => $descripcion,
                            'activo'      => $activo
                        ]);
                    }
                }

                $this->db->commit();
                header('Location: ' . BASE_URL . '/consultorio/index?success=1');
                exit;

            } catch (Exception $e) {
                $this->db->rollBack();
                // Manejar error o redirigir con mensaje de fallo si es necesario
                header('Location: ' . BASE_URL . '/consultorio/index?error=1');
                exit;
            }
        }
    }
}