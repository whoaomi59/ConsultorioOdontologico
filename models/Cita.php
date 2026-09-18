<?php
class Cita {
    private $db;

    public function __construct($db = null) {
        if ($db === null) {
            global $db;
        }
        $this->db = $db;
    }

    public function getAll() {
        $sql = "SELECT c.*, p.nombre AS paciente_nombre, p.apellido AS paciente_apellido, p.telefono AS paciente_telefono
            FROM citas c
            INNER JOIN pacientes p ON c.paciente_id = p.id
            ORDER BY c.fecha DESC, c.hora DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT c.*, p.nombre AS paciente_nombre, p.apellido AS paciente_apellido
            FROM citas c
            INNER JOIN pacientes p ON c.paciente_id = p.id
            WHERE c.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO citas (paciente_id, fecha, hora, hora_final, motivo, estado)
            VALUES (:paciente_id, :fecha, :hora, :hora_final, :motivo, :estado)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':paciente_id' => $data['paciente_id'],
            ':fecha'       => $data['fecha'],
            ':hora'        => $data['hora'],
            ':hora_final'    => $data['hora_final'],
            ':motivo'      => $data['motivo'],
            ':estado'      => $data['estado'] ?? 'pendiente'
        ]);
    }



    public function update($datos) {
        // Ejemplo usando PDO (ajusta la consulta según cómo estés conectando tu base de datos)
        $sql  = "UPDATE citas SET paciente_id = ?, fecha = ?, hora = ?, hora_final = ?, estado = ?, motivo = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['paciente_id'],
            $datos['fecha'],
            $datos['hora'],
            $datos['hora_final'],
            $datos['estado'], // <- Importante para que guarde el cambio de estado
            $datos['motivo'],
            $datos['id']
        ]);
    }

    public function updateEstado($id, $estado) {
        $sql  = "UPDATE citas SET estado = :estado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':estado' => $estado, ':id' => $id]);
    }

    public function delete($id) {
        $sql  = "DELETE FROM citas WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}