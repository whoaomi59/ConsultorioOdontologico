<?php
class Usuario {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ? AND estado = 1 LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT id, nombre, email, rol, estado, creado_en FROM usuarios ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $hashPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt         = $this->db->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['nombre'],
            $data['email'],
            $hashPassword,
            $data['rol']
        ]);
    }

    public function updateEstado($id, $estado) {
        $stmt = $this->db->prepare("UPDATE usuarios SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }
}
?>