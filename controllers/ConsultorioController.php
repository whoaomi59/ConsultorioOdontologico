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

    // Mostrar el formulario de configuración del consultorio
    public function index() {
        requirePermission('configuracion'); // Ajusta según tu sistema de permisos

        $consultorio = $this->consultorioModel->getInfo();

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/consultorio/index.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // Guardar o actualizar la información del consultorio
    public function guardar() {
        requirePermission('configuracion');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre    = trim($_POST['nombre'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $logoPath  = $_POST['logo_actual'] ?? '';

            // Procesar la subida del logo si se adjuntó uno nuevo
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath   = $_FILES['logo']['tmp_name'];
                $fileName      = $_FILES['logo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (in_array($fileExtension, $allowedExtensions)) {
                    // Asegurar que la ruta apunte correctamente dentro de public/uploads/
                    $uploadRelativeDir = 'public/uploads/consultorio/';
                    $uploadAbsoluteDir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/sistema_clinico/' . $uploadRelativeDir;

                    if (!is_dir($uploadAbsoluteDir)) {
                        mkdir($uploadAbsoluteDir, 0755, true);
                    }

                    $newFileName = 'logo_consultorio_' . time() . '.' . $fileExtension;
                    $destPath    = $uploadAbsoluteDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        // Guardamos la ruta relativa que se usará en las etiquetas <img>
                        $logoPath = $uploadRelativeDir . $newFileName;
                    }
                }
            }

            // Verificar si ya existe un registro para actualizar o insertar
            $infoActual = $this->consultorioModel->getInfo();

            if ($infoActual) {
                // Actualizar
                $query = "UPDATE consultorio SET Nombre = :nombre, direccion = :direccion, Logo = :logo WHERE ID = :id";
                $stmt  = $this->db->prepare($query);
                $stmt->execute([
                    'nombre'    => $nombre,
                    'direccion' => $direccion,
                    'logo'      => $logoPath,
                    'id'        => $infoActual['ID']
                ]);
            } else {
                // Insertar
                $query = "INSERT INTO consultorio (Nombre, direccion, Logo) VALUES (:nombre, :direccion, :logo)";
                $stmt  = $this->db->prepare($query);
                $stmt->execute([
                    'nombre'    => $nombre,
                    'direccion' => $direccion,
                    'logo'      => $logoPath
                ]);
            }

            header('Location: ' . BASE_URL . '/consultorio/index?success=1');
            exit;
        }
    }
}