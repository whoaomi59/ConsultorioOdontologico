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

    public function getByPacienteId($paciente_id) {
        $stmt = $this->db->prepare("SELECT * FROM historias_clinicas WHERE paciente_id = ? ORDER BY id DESC");
        $stmt->execute([$paciente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO historias_clinicas (
            paciente_id, motivo_consulta, diagnostico, tratamiento,
            observaciones, odontograma, acudiente_nombre,
            acudiente_documento, acudiente_parentesco, firma_base64
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['paciente_id'],
            $data['motivo_consulta'],
            $data['diagnostico'],
            $data['tratamiento'],
            $data['observaciones'],
            $data['odontograma'],
            $data['acudiente_nombre'],
            $data['acudiente_documento'],
            $data['acudiente_parentesco'],
            $data['firma_base64']
        ]);
    }
}
?>