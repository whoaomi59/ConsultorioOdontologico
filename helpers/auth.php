<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica si el usuario ha iniciado sesión.
 * Si no hay sesión, redirige al login.
 */
function checkAuth() {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}

/**
 * Restringe el acceso a ciertos roles.
 * Si no está autenticado o no tiene el rol permitido, redirige al login.
 */
function requireRole(array $rolesPermitidos) {
    // 1. Primero verifica que haya iniciado sesión (si no, checkAuth redirige a /login)
    checkAuth();

    // 2. Obtener el rol actual de la sesión
    $rolActual = $_SESSION['usuario_rol'] ?? null;

    // 3. Si no tiene rol o el rol no está en la lista de permitidos, redirigir a /login
    if (!$rolActual || !in_array($rolActual, $rolesPermitidos)) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
?>