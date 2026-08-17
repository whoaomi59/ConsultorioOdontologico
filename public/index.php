<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Definir la ruta raíz del proyecto en el sistema de archivos
define('ROOT_PATH', dirname(__DIR__));
define('BASE_URL', '/sistema_clinico');

require_once ROOT_PATH . '/config/database.php';
require_once '../helpers/auth.php';

// Autoload
spl_autoload_register(function ($clase) {
    $directorios = ['/controllers/', '/models/'];
    foreach ($directorios as $directorio) {
        $file = ROOT_PATH . $directorio . $clase . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Obtener URL y procesar ruta
$rawUrl = $_GET['url'] ?? 'paciente/index';
$rawUrl = trim($rawUrl, '/');

if ($rawUrl === '' || $rawUrl === 'public') {
    $rawUrl = 'paciente/index';
}

// Redirecciones directas para Login y Logout
if ($rawUrl === 'login') {
    $rawUrl = 'auth/showLogin';
} elseif ($rawUrl === 'logout') {
    $rawUrl = 'auth/logout';
}

$urlParts = explode('/', filter_var($rawUrl, FILTER_SANITIZE_URL));

$controllerBase = !empty($urlParts[0]) ? $urlParts[0] : 'paciente';
$controllerName = ucfirst($controllerBase) . 'Controller';

$action = !empty($urlParts[1]) ? $urlParts[1] : 'index';
$id     = $urlParts[2] ?? null;

if (class_exists($controllerName)) {
    // Si la variable $db no está definida en database.php, evita pasar null descontrolado
    $conexionDb = isset($db) ? $db : null;
    $controller = new $controllerName($conexionDb);

    if (method_exists($controller, $action)) {
        $controller->$action($id);
    } else {
        http_response_code(404);
        echo "Error 404: El método <strong>{$action}</strong> no existe en <strong>{$controllerName}</strong>.";
    }
} else {
    http_response_code(404);
    echo "Error 404: El controlador <strong>{$controllerName}</strong> no fue encontrado.";
}