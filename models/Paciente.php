<?php
class Paciente {
    private $db;

    // Recibir la conexión PDO directamente en el constructor
    public function __construct($dbConnection = null) {
        if ($dbConnection === null) {
            global $db;
            $this->db = $db;
        } else {
            $this->db = $dbConnection;
        }
    }



    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM pacientes ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM pacientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscar($termino) {
        $sql = "SELECT * FROM pacientes
            WHERE nombre LIKE ?
            OR apellido LIKE ?
            OR documento LIKE ?
            ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $like = "%" . $termino . "%";
        $stmt->execute([$like, $like, $like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO pacientes
            (nombre, apellido, tipo_documento, documento, fecha_nacimiento, telefono, email, foto)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        return $stmt->execute([
            $data['nombre'],
            $data['apellido'],
            $data['tipo_documento'],
            $data['documento'],
            $data['fecha_nacimiento'],
            $data['telefono'],
            $data['email'],
            $data['foto']
        ]);
    }

    public function update($data) {
        $stmt = $this->db->prepare("UPDATE pacientes SET
            nombre = ?, apellido = ?, tipo_documento = ?, documento = ?,
            fecha_nacimiento = ?, telefono = ?, email = ?, foto = ?
            WHERE id = ?");

        return $stmt->execute([
            $data['nombre'],
            $data['apellido'],
            $data['tipo_documento'],
            $data['documento'],
            $data['fecha_nacimiento'],
            $data['telefono'],
            $data['email'],
            $data['foto'],
            $data['id']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM pacientes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}