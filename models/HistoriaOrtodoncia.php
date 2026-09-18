<?php
class HistoriaOrtodoncia {
    private $db;

    public function __construct($dbConnection = null) {
        if ($dbConnection === null) {
            global $db;
            $this->db = $db;
        } else {
            $this->db = $dbConnection;
        }
    }

    public function getByPacienteId($paciente_id) {
        $sql = "SELECT h.*, u.nombre AS doctor_nombre, u.firma_base64 AS doctor_firma_base64
            FROM historias_ortodoncia h
            LEFT JOIN usuarios u ON h.usuario_id = u.id
            WHERE h.paciente_id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$paciente_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEvolucionesByHistoriaId($historia_id) {
        $sql = "SELECT e.*, u.nombre AS doctor_nombre
            FROM ortodoncia_evoluciones e
            LEFT JOIN usuarios u ON e.usuario_id = u.id
            WHERE e.historia_id = ?
            ORDER BY e.fecha_consulta DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$historia_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createDiagnostico($data) {
        unset($data['id'], $data['historia_id']);

        $columns      = array_keys($data);
        $placeholders = implode(', ', array_fill(0, count($columns), '?'));
        $colNames     = implode(', ', array_map(function($col) { return "`$col`"; }, $columns));

        $sql  = "INSERT INTO historias_ortodoncia ({$colNames}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(array_values($data));
    }

    public function updateDiagnostico($historia_id, $data) {
        unset($data['id'], $data['paciente_id'], $data['historia_id']);

        if (empty($data)) {
            return false;
        }

        $fields = [];
        foreach (array_keys($data) as $column) {
            $fields[] = "`{$column}` = ?";
        }
        $setClause = implode(', ', $fields);

        $sql = "UPDATE historias_ortodoncia SET {$setClause} WHERE id = ?";

        $values   = array_values($data);
        $values[] = $historia_id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function createEvolucion($data) {
        $sql = "INSERT INTO ortodoncia_evoluciones
            (historia_id, usuario_id, descripcion_evolucion, valor_evolucion, radiografia_pdf, firma_paciente_base64)
            VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['historia_id'],
            $data['usuario_id'],
            $data['descripcion_evolucion'],
            $data['valor_evolucion'],
            $data['radiografia_pdf'],
            $data['firma_paciente_base64'] ?? null
        ]);
    }
}
?>