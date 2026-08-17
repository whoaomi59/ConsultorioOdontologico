<?php
require_once ROOT_PATH . '/helpers/auth.php';
require_once ROOT_PATH . '/models/Usuario.php';

class UsuariosController {
    private $usuarioModel;

    public function __construct($db = null) {
        requireRole(['admin']);

        if ($db === null) {
            global $db;
        }

        $this->usuarioModel = new Usuario($db);
    }

    public function index() {
        //para obligar la autenticacion requireRole(['admin']);
        $usuarios = $this->usuarioModel->getAll();

        // 1. Cargar Cabecera (Contiene Tailwind CSS y Sidebar)
        require_once ROOT_PATH . '/views/layout/header.php';

        // 2. Cargar Vista del Módulo de Usuarios
        require_once ROOT_PATH . '/views/usuarios/index.php';

        // 3. Cargar Pie de página y Scripts JS (Lucide Icons)
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre'   => trim($_POST['nombre'] ?? ''),
                'email'    => trim($_POST['email'] ?? ''),
                'password' => trim($_POST['password'] ?? ''),
                'rol'      => trim($_POST['rol'] ?? 'odontologo')
            ];

            if (!empty($data['nombre']) && !empty($data['email']) && !empty($data['password'])) {
                $this->usuarioModel->create($data);
            }

            header('Location: ' . BASE_URL . '/usuarios');
            exit;
        }
    }

    public function cambiarEstado($id, $estado) {
        $this->usuarioModel->updateEstado($id, (int)$estado);
        header('Location: ' . BASE_URL . '/usuarios');
        exit;
    }
}
?>