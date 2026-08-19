<?php
require_once ROOT_PATH . '/helpers/auth.php';
require_once ROOT_PATH . '/models/Cita.php';
require_once ROOT_PATH . '/models/Paciente.php';
require_once ROOT_PATH . '/models/HistoriaClinica.php';

class ReporteController {
    private $citaModel;
    private $pacienteModel;
    private $historiaModel;
    private $db;

    public function __construct($db = null) {
        if ($db === null) {
            global $db;
        }
        $this->db = $db;

        // Instancia de los modelos necesarios para métricas y gráficos
        $this->citaModel     = new Cita($this->db);
        $this->pacienteModel = new Paciente($this->db);
        $this->historiaModel = new HistoriaClinica($this->db);
    }

    // PÁGINA PRINCIPAL DE REPORTES / DASHBOARD ANALÍTICO
    public function index() {
        requirePermission('reportes');

        // Filtros de fecha (Por defecto el mes actual)
        $fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
        $fechaFin    = $_GET['fecha_fin'] ?? date('Y-m-t');

        // Consultas analíticas para estadísticas
        $statsCitas      = $this->getEstadisticasCitas($fechaInicio, $fechaFin);
        $pacientesNuevos = $this->getPacientesNuevosCount($fechaInicio, $fechaFin);

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/reporte/index.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // REPORTE ESPECÍFICO DE CITAS
    public function citas() {
        requirePermission('reportes');

        $fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
        $fechaFin    = $_GET['fecha_fin'] ?? date('Y-m-t');
        $estado      = $_GET['estado'] ?? 'todos';

        $citas = $this->getReporteCitasDetallado($fechaInicio, $fechaFin, $estado);

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/reporte/citas.php';
        require_once ROOT_PATH . '/views/layout/footer.php';
    }

    // EXPORTAR REPORTE DE CITAS A CSV (APTO PARA EXCEL)
    public function exportarCitasCsv() {
        requirePermission('reportes');

        $fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
        $fechaFin    = $_GET['fecha_fin'] ?? date('Y-m-t');
        $estado      = $_GET['estado'] ?? 'todos';

        $citas = $this->getReporteCitasDetallado($fechaInicio, $fechaFin, $estado);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=reporte_citas_' . date('Ymd_His') . '.csv');

        $output = fopen('php://output', 'w');
        // Encabezados UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['ID Cita', 'Fecha', 'Hora', 'Paciente', 'Teléfono', 'Doctor', 'Motivo', 'Estado']);

        foreach ($citas as $c) {
            fputcsv($output, [
                $c['id'] ?? '',
                $c['fecha'] ?? '',
                $c['hora'] ?? '',
                ($c['paciente_nombre'] ?? '') . ' ' . ($c['paciente_apellido'] ?? ''),
                $c['paciente_telefono'] ?? '',
                $c['doctor_nombre'] ?? '',
                $c['motivo'] ?? '',
                $c['estado'] ?? ''
            ]);
        }

        fclose($output);
        exit;
    }

    // --- MÉTODOS AUXILIARES DE CONSULTA PDO ---

    private function getEstadisticasCitas($inicio, $fin) {
        if (!$this->db) { return ['total' => 0, 'atendidas' => 0, 'canceladas' => 0, 'pendientes' => 0]; }

        $stmt = $this->db->prepare("
            SELECT
            COUNT(*) as total,
            SUM(CASE WHEN estado = 'atendida' THEN 1 ELSE 0 END) as atendidas,
            SUM(CASE WHEN estado = 'cancelada' THEN 1 ELSE 0 END) as canceladas,
            SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes
            FROM citas
            WHERE fecha BETWEEN :inicio AND :fin
            ");
        $stmt->execute([':inicio' => $inicio, ':fin' => $fin]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function getPacientesNuevosCount($inicio, $fin) {
        if (!$this->db) { return 0; }

        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM pacientes
            WHERE DATE(created_at) BETWEEN :inicio AND :fin
            ");
        $stmt->execute([':inicio' => $inicio, ':fin' => $fin]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['total'] ?? 0;
    }

    private function getReporteCitasDetallado($inicio, $fin, $estado) {
        if (!$this->db) { return []; }

        $sql = "
            SELECT c.*,
            p.nombre as paciente_nombre, p.apellido as paciente_apellido, p.telefono as paciente_telefono,
            u.nombre as doctor_nombre
            FROM citas c
            LEFT JOIN pacientes p ON c.paciente_id = p.id
            LEFT JOIN usuarios u ON c.usuario_id = u.id
            WHERE c.fecha BETWEEN :inicio AND :fin
            ";

        $params = [':inicio' => $inicio, ':fin' => $fin];

        if ($estado !== 'todos') {
            $sql .= " AND c.estado = :estado";
            $params[':estado'] = $estado;
        }

        $sql .= " ORDER BY c.fecha DESC, c.hora ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}