<?php
require_once ROOT_PATH . '/helpers/auth.php';
require_once ROOT_PATH . '/models/Cita.php';
require_once ROOT_PATH . '/models/Paciente.php';
require_once ROOT_PATH . '/models/HistoriaClinica.php';
require_once ROOT_PATH . '/models/HistoriaOrtodoncia.php';

class ReporteController {
    private $citaModel;
    private $pacienteModel;
    private $historiaModel;
    private $ortodonciaModel;
    private $db;

    public function __construct($db = null) {
        if ($db === null) {
            global $db;
        }
        $this->db = $db;

        // Instancia de los modelos necesarios para métricas y gráficos
        $this->citaModel       = new Cita($this->db);
        $this->pacienteModel   = new Paciente($this->db);
        $this->historiaModel   = new HistoriaClinica($this->db);
        $this->ortodonciaModel = new HistoriaOrtodoncia($this->db);
    }

    // PÁGINA PRINCIPAL DE REPORTES / DASHBOARD ANALÍTICO
    public function index() {
        requirePermission('reportes');

        // Filtros de fecha (Por defecto el mes actual)
        $fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
        $fechaFin    = $_GET['fecha_fin'] ?? date('Y-m-t');

        // Consultas analíticas generales y estadísticas sincronizadas con la vista
        $reporteGeneral = $this->getReporteGeneralEstadisticas($fechaInicio, $fechaFin);

        require_once ROOT_PATH . '/views/layout/header.php';
        require_once ROOT_PATH . '/views/reporte/index.php'; // Asegúrate de que apunte a tu archivo de vista general
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

    /**
     * Consolidado completo sincronizado con la vista del Dashboard Analítico Global
     */
    private function getReporteGeneralEstadisticas($inicio, $fin) {
        if (!$this->db) { return []; }

        $params   = [':inicio' => $inicio, ':fin' => $fin];
        $metricas = [];

        try {
            // 1. Pacientes Totales y con Historia
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM pacientes WHERE DATE(created_at) BETWEEN :inicio AND :fin");
            $stmt->execute($params);
            $metricas['pacientes_totales'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

            $stmt                               = $this->db->query("SELECT COUNT(DISTINCT paciente_id) as total FROM historias_clinicas");
            $metricas['pacientes_con_historia'] = $stmt ? ($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0) : 0;

            // 2. Desglose de Citas en el rango
            $stmt = $this->db->prepare("
                SELECT
                COUNT(*) as total,
                SUM(CASE WHEN estado = 'atendida' THEN 1 ELSE 0 END) as atendidas,
                SUM(CASE WHEN estado = 'cancelada' THEN 1 ELSE 0 END) as canceladas,
                SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                SUM(CASE WHEN estado = 'confirmada' THEN 1 ELSE 0 END) as confirmadas
                FROM citas
                WHERE fecha BETWEEN :inicio AND :fin
                ");
            $stmt->execute($params);
            $metricas['citas'] = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['total' => 0, 'atendidas' => 0, 'canceladas' => 0, 'pendientes' => 0, 'confirmadas' => 0];

            // 3. Historias Clínicas Generales
            $stmt                                   = $this->db->query("SELECT COUNT(*) as total FROM historias_clinicas");
            $metricas['historias_clinicas_totales'] = $stmt ? ($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0) : 0;

            // Intentar consultar tabla base si existe
            try {
                $stmt                               = $this->db->query("SELECT COUNT(*) as total FROM historias_clinicas_base");
                $metricas['historias_base_totales'] = $stmt ? ($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0) : 0;
            } catch (Exception $ex) {
                $metricas['historias_base_totales'] = $metricas['historias_clinicas_totales'];
            }

            // 4. Ortodoncia Diagnósticos y Estadísticas de Evoluciones en el rango
            $stmt                                 = $this->db->query("SELECT COUNT(*) as total FROM historias_ortodoncia");
            $metricas['ortodoncias_diagnosticos'] = $stmt ? ($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0) : 0;

            $stmt = $this->db->prepare("
                SELECT
                COUNT(*) as total_evoluciones,
                COALESCE(SUM(valor_evolucion), 0) as valor_recaudado_total,
                COALESCE(AVG(valor_evolucion), 0) as valor_promedio_evolucion
                FROM ortodoncia_evoluciones
                WHERE fecha_consulta BETWEEN :inicio AND :fin
                ");
            $stmt->execute($params);
            $metricas['ortodoncia_evoluciones_stats'] = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['total_evoluciones' => 0, 'valor_recaudado_total' => 0, 'valor_promedio_evolucion' => 0];

            // 5. Rendimiento y Valores por Doctor de Ortodoncia
            $sqlDoctores = "
                SELECT
                u.id AS doctor_id,
                u.nombre AS doctor_nombre,
                u.email AS doctor_email,
                COUNT(e.id) AS total_consultas,
                COALESCE(SUM(e.valor_evolucion), 0) AS valor_total
                FROM usuarios u
                JOIN ortodoncia_evoluciones e ON u.id = e.usuario_id
                WHERE e.fecha_consulta BETWEEN :inicio AND :fin
                GROUP BY u.id, u.nombre, u.email
                ORDER BY valor_total DESC
                ";
            $stmt = $this->db->prepare($sqlDoctores);
            $stmt->execute($params);
            $metricas['doctores_ortodoncia'] = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

            // 6. Rendimiento de Odontología General por Doctor
            try {
                $sqlOdontologos = "
                    SELECT
                    u.id AS doctor_id,
                    u.nombre AS doctor_nombre,
                    COUNT(h.id) AS total_consultas_odontologia
                    FROM usuarios u
                    JOIN historias_clinicas h ON u.id = h.usuario_id
                    GROUP BY u.id, u.nombre
                    ORDER BY total_consultas_odontologia DESC
                    ";
                $stmt                             = $this->db->query($sqlOdontologos);
                $metricas['doctores_odontologia'] = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
            } catch (Exception $ex) {
                $metricas['doctores_odontologia'] = [];
            }

        } catch (Exception $e) {
            // Manejo silencioso ante variaciones de tablas
        }

        return $metricas;
    }
}