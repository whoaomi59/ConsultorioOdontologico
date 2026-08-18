<?php
require_once ROOT_PATH . '/helpers/auth.php';

class DashboardController {

    public function __construct() {
        checkAuth(); // Verifica que haya sesión activa
    }

    public function index() {
        global $db;

        // Consultas sencillas para las estadísticas del Dashboard
        $stats = [
            'pacientes'  => $db->query("SELECT COUNT(*) FROM pacientes")->fetchColumn() ?? 0,
            'citas_hoy'  => $db->query("SELECT COUNT(*) FROM citas WHERE DATE(fecha) = CURDATE()")->fetchColumn() ?? 0,
            'historias'  => $db->query("SELECT COUNT(*) FROM historias_clinicas")->fetchColumn() ?? 0,
            'doctores'   => $db->query("SELECT COUNT(*) FROM usuarios WHERE estado = 1")->fetchColumn() ?? 0,
        ];

        // Cargar vista del dashboard
        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/dashboard/index.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }
}
?>