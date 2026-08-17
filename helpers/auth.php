<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica si el usuario ha iniciado sesión.
 */
function checkAuth() {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}

/**
 * Restringe el acceso a ciertos roles.
 */
function requireRole(array $rolesPermitidos) {
    checkAuth();

    // Obtener el rol actual o null si no está definido
    $rolActual = $_SESSION['usuario_rol'] ?? null;

    if (!$rolActual || !in_array($rolActual, $rolesPermitidos)) {
        http_response_code(403);
        echo "<h1 style='text-align:center; margin-top:50px; font-family:sans-serif;'>403 - Acceso No Autorizado</h1>";
        exit;
    }
}
?>