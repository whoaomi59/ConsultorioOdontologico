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
    $rolActual = $_SESSION['usuario_rol'] ?? null;

    if (!$rolActual || !in_array($rolActual,$rolesPermitidos)) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}

/**
 * Verifica si el usuario tiene permiso para un módulo específico.
 */
function hasPermission(string $modulo): bool {
    // Los administradores siempre tienen acceso total
    if (($_SESSION['usuario_rol'] ?? '') === 'admin') {
        return true;
    }

    $permisos = $_SESSION['usuario_permisos'] ?? [];
    return in_array($modulo,$permisos);
}

/**
 * Valida el permiso para acceder al módulo. Redirige si no tiene acceso.
 */
function requirePermission(string $modulo) {
    checkAuth();

    if (!hasPermission($modulo)) {$_SESSION['error_acceso'] = "No tienes permisos para acceder al módulo de " . ucfirst($modulo) . ".";
        header('Location: ' . BASE_URL . '/historias/odontologia');
        exit;
    }
}
?>