<?php
require_once ROOT_PATH . '/models/Usuario.php';

class AuthController {
    private $usuarioModel;

    public function __construct($db = null) {
        if ($db === null) {
            global $db;
        }

        $this->usuarioModel = new Usuario($db);
    }

    // Alias para el enrutador predeterminado
    public function index() {
        $this->showLogin();
    }

    public function showLogin() {
        if (isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/historias/odontologia');
            exit;
        }
        require_once ROOT_PATH . '/views/auth/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $user = $this->usuarioModel->getByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['usuario_id']     = $user['id'];
                $_SESSION['usuario_nombre'] = $user['nombre'];
                $_SESSION['usuario_email']  = $user['email'];
                $_SESSION['usuario_rol']    = $user['rol'];

                header('Location: ' . BASE_URL . '/historias/odontologia');
                exit;
            } else {
                $_SESSION['error'] = 'Credenciales incorrectas o usuario inactivo.';
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
        }
    }

    // Alias si el formulario de login envía a /login/autenticar
    public function autenticar() {
        $this->login();
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
?>