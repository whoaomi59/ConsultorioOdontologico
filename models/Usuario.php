<?php
class Usuario {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM usuarios ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ? AND estado = 1 LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $hashPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt         = $this->db->prepare("INSERT INTO usuarios (nombre, email, password, rol, foto, estado) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->execute([$data['nombre'],
            $data['email'],$hashPassword,
            $data['rol'],$data['foto'] ?? null
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id,$data) {
        if (!empty($data['password'])) {$hashPassword = password_hash($data['password'], PASSWORD_BCRYPT);$sql = "UPDATE usuarios SET nombre = ?, email = ?, password = ?, rol = ?, estado = ?" . ($data['foto'] ? ", foto = ?" : "") . " WHERE id = ?";
            $params = [$data['nombre'], $data['email'],$hashPassword, $data['rol'],$data['estado']];
        } else {
            $sql    = "UPDATE usuarios SET nombre = ?, email = ?, rol = ?, estado = ?" . ($data['foto'] ? ", foto = ?" : "") . " WHERE id = ?";
            $params = [$data['nombre'],$data['email'], $data['rol'],$data['estado']];
        }

        if ($data['foto']) {
            $params[] = $data['foto'];
        }
        $params[] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // --- GESTIÓN DE PERMISOS POR MÓDULO ---
    public function getPermisos($usuario_id) {
        $stmt = $this->db->prepare("SELECT modulo FROM usuario_permisos WHERE usuario_id = ?");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function syncPermisos($usuario_id, array$modulos) {
        $stmtDel = $this->db->prepare("DELETE FROM usuario_permisos WHERE usuario_id = ?");
        $stmtDel->execute([$usuario_id]);

        $stmtIns = $this->db->prepare("INSERT INTO usuario_permisos (usuario_id, modulo) VALUES (?, ?)");
        foreach ($modulos as $modulo) {$stmtIns->execute([$usuario_id,$modulo]);
        }
    }
}
?>