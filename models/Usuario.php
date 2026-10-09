<?php

class Usuario
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /* =========================================================
       USUARIOS
    ========================================================= */

    public function getAll()
    {
        $sql = 'SELECT * FROM usuarios ORDER BY id DESC';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = 'SELECT * FROM usuarios WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email)
    {
        $sql = 'SELECT * FROM usuarios WHERE email = ? AND estado = 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO usuarios
            (nombre, email, password, rol, foto, firma_base64, estado)
            VALUES (?, ?, ?, ?, ?, ?, 1)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$data['nombre'], $data['email'], $data['password'], $data['rol'], $data['foto'] ?? null, $data['firma_base64'] ?? null]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $campos = ['nombre = ?', 'email = ?', 'rol = ?', 'estado = ?'];

        $valores = [$data['nombre'], $data['email'], $data['rol'], $data['estado']];

        if (isset($data['password']) && trim($data['password']) !== '') {
            $campos[] = 'password = ?';
            $valores[] = $data['password'];
        }

        if (array_key_exists('foto', $data)) {
            $campos[] = 'foto = ?';
            $valores[] = $data['foto'];
        }

        if (array_key_exists('firma_base64', $data)) {
            $campos[] = 'firma_base64 = ?';
            $valores[] = $data['firma_base64'];
        }

        $valores[] = $id;

        $sql = 'UPDATE usuarios SET ' . implode(', ', $campos) . ' WHERE id = ?';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($valores);
    }

    public function getPermisos($usuario_id)
    {
        $sql = "SELECT modulo
            FROM usuario_permisos
            WHERE usuario_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function syncPermisos($usuario_id, $modulos)
    {
        $sql = 'DELETE FROM usuario_permisos WHERE usuario_id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id]);

        if (!empty($modulos)) {
            $sqlInsert = "INSERT INTO usuario_permisos
                (usuario_id, modulo)
                VALUES (?, ?)";

            $stmtInsert = $this->db->prepare($sqlInsert);

            foreach ($modulos as $modulo) {
                $stmtInsert->execute([$usuario_id, $modulo]);
            }
        }
    }

    public function updateUltimoAcceso($id)
    {
        $sql = "UPDATE usuarios
            SET ultimo_acceso = NOW()
            WHERE id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }

    /* =========================================================
       AGENDA PERSONAL DEL DOCTOR
    ========================================================= */

    public function getFechasAtencion($usuarioId)
    {
        $sql = "SELECT
            id,
            usuario_id,
            fecha,
            hora_inicio
            FROM fechas_atencion_doctores
            WHERE usuario_id = ?
            ORDER BY fecha ASC, hora_inicio ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuarioId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFechasAtencionFuturas($usuarioId)
    {
        $sql = "SELECT
            id,
            usuario_id,
            fecha,
            hora_inicio
            FROM fechas_atencion_doctores
            WHERE usuario_id = ?
            AND fecha >= CURDATE()
            ORDER BY fecha ASC, hora_inicio ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuarioId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Comprueba si una fecha ya fue asignada a otro doctor.
     */
    public function fechaAtencionAsignadaAOtroDoctor($usuarioId, $fecha)
    {
        $sql = "SELECT id
            FROM fechas_atencion_doctores
            WHERE fecha = ?
            AND usuario_id <> ?
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$fecha, (int) $usuarioId]);

        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fechaAtencionExiste($usuarioId, $fecha, $hora)
    {
        $sql = "SELECT id
            FROM fechas_atencion_doctores
            WHERE usuario_id = ?
            AND fecha = ?
            AND hora_inicio = ?
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuarioId, $fecha, $hora]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearFechaAtencion($usuarioId, $fecha, $hora)
    {
        $sql = "INSERT INTO fechas_atencion_doctores
            (usuario_id, fecha, hora_inicio)
            VALUES (?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$usuarioId, $fecha, $hora]);
    }

    public function getFechaAtencionById($id, $usuarioId)
    {
        $sql = "SELECT *
            FROM fechas_atencion_doctores
            WHERE id = ?
            AND usuario_id = ?";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$id, $usuarioId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminarFechaAtencion($id, $usuarioId)
    {
        $sql = "DELETE FROM fechas_atencion_doctores
            WHERE id = ?
            AND usuario_id = ?
            AND fecha >= CURDATE()";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id, $usuarioId]);
    }
}
