<?php
class HistoriaClinica {
    private $db;

    public function __construct($dbConnection = null) {
        if ($dbConnection === null) {
            global $db;
            $this->db = $db;
        } else {
            $this->db = $dbConnection;
        }
    }

    // Trae las historias clínicas incluyendo los datos del doctor que la creó
    public function getByPacienteId($paciente_id) {$sql = "SELECT h.*, u.nombre AS doctor_nombre, u.email AS doctor_email
        FROM historias_clinicas h
        LEFT JOIN usuarios u ON h.usuario_id = u.id
        WHERE h.paciente_id = ?
        ORDER BY h.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$paciente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {$sql = "INSERT INTO historias_clinicas (
        paciente_id, usuario_id, motivo_consulta, diagnostico, tratamiento,
        observaciones, odontograma, acudiente_nombre,
        acudiente_documento, acudiente_parentesco, firma_base64, firma_doctor_base64
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['paciente_id'],$data['usuario_id'],
            $data['motivo_consulta'],$data['diagnostico'],
            $data['tratamiento'],$data['observaciones'],
            $data['odontograma'],$data['acudiente_nombre'],
            $data['acudiente_documento'],$data['acudiente_parentesco'],
            $data['firma_base64'],$data['firma_doctor_base64']
        ]);
    }
}
?>