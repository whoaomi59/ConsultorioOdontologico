<?php

class Cita
{
    private $db;

    public function __construct($db = null)
    {
        if ($db === null) {
            global $db;
        }

        $this->db = $db;
    }

    /*
    |--------------------------------------------------------------------------
    | OBTENER TODAS LAS CITAS
    |--------------------------------------------------------------------------
    */

    public function getAll()
    {
        $sql = "SELECT
            c.*,
            p.nombre AS paciente_nombre,
            p.apellido AS paciente_apellido,
            p.telefono AS paciente_telefono
            FROM citas c
            INNER JOIN pacientes p
            ON c.paciente_id = p.id
            ORDER BY c.fecha DESC, c.hora DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | OBTENER UNA CITA POR ID
    |--------------------------------------------------------------------------
    */

    public function getById($id)
    {
        $sql = "SELECT
            c.*,
            p.nombre AS paciente_nombre,
            p.apellido AS paciente_apellido,
            p.telefono AS paciente_telefono
            FROM citas c
            INNER JOIN pacientes p
            ON c.paciente_id = p.id
            WHERE c.id = :id
            LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id,
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | OBTENER FECHAS PROGRAMADAS PARA UN DOCTOR
    |--------------------------------------------------------------------------
    */

    public function getFechasAtencionDoctor($usuarioId)
    {
        $sql = "SELECT
            id,
            usuario_id,
            fecha,
            hora_inicio
            FROM fechas_atencion_doctores
            WHERE usuario_id = :usuario_id
            ORDER BY fecha ASC, hora_inicio ASC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':usuario_id' => $usuarioId,
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | OBTENER CITAS DE LAS FECHAS PROGRAMADAS PARA EL DOCTOR
    |--------------------------------------------------------------------------
    */

    public function getCitasPorFechasDoctor($usuarioId)
    {
        $sql = "SELECT DISTINCT
            c.*,
            p.nombre AS paciente_nombre,
            p.apellido AS paciente_apellido,
            p.telefono AS paciente_telefono
            FROM citas c
            INNER JOIN pacientes p
            ON c.paciente_id = p.id
            INNER JOIN fechas_atencion_doctores fad
            ON fad.fecha = c.fecha
            AND fad.usuario_id = :usuario_id
            ORDER BY c.fecha DESC, c.hora DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':usuario_id' => $usuarioId,
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | COMPROBAR SI UNA FECHA ESTÁ PROGRAMADA PARA EL DOCTOR
    |--------------------------------------------------------------------------
    */

    /**
     * Indica si la fecha está asignada a un doctor diferente.
     */
    public function fechaAsignadaAOtroDoctor($usuarioId, $fecha)
    {
        if (empty($usuarioId) || empty($fecha)) {
            return false;
        }

        $sql = "SELECT id
            FROM fechas_atencion_doctores
            WHERE fecha = :fecha
            AND usuario_id <> :usuario_id
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':fecha' => $fecha,
            ':usuario_id' => (int) $usuarioId,
        ]);

        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fechaEstaProgramada($usuarioId, $fecha)
    {
        if (empty($usuarioId) || empty($fecha)) {
            return false;
        }

        $usuarioId = (int) $usuarioId;
        $fecha = trim((string) $fecha);

        // Validar el formato recibido del formulario.
        $fechaSeleccionada = DateTime::createFromFormat('!Y-m-d', $fecha);

        if (!$fechaSeleccionada || $fechaSeleccionada->format('Y-m-d') !== $fecha) {
            return false;
        }

        // Obtener las mismas fechas que utiliza la agenda.
        $fechasProgramadas = $this->getFechasAtencionDoctor($usuarioId);

        foreach ($fechasProgramadas as $fila) {
            if (empty($fila['fecha'])) {
                continue;
            }

            $fechaProgramada = date('Y-m-d', strtotime($fila['fecha']));

            if ($fechaProgramada === $fecha) {
                return true;
            }
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | CREAR CITA
    |--------------------------------------------------------------------------
    */

    public function create($data)
    {
        $sql = "INSERT INTO citas (
            paciente_id,
            fecha,
            hora,
            hora_final,
            motivo,
            estado
            ) VALUES (
            :paciente_id,
            :fecha,
            :hora,
            :hora_final,
            :motivo,
            :estado
            )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':paciente_id' => $data['paciente_id'],
            ':fecha' => $data['fecha'],
            ':hora' => $data['hora'],
            ':hora_final' => $data['hora_final'],
            ':motivo' => $data['motivo'],
            ':estado' => $data['estado'],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR CITA
    |--------------------------------------------------------------------------
    */

    public function update($data)
    {
        $sql = "UPDATE citas
            SET
            paciente_id = :paciente_id,
            fecha = :fecha,
            hora = :hora,
            hora_final = :hora_final,
            motivo = :motivo,
            estado = :estado
            WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $data['id'],
            ':paciente_id' => $data['paciente_id'],
            ':fecha' => $data['fecha'],
            ':hora' => $data['hora'],
            ':hora_final' => $data['hora_final'],
            ':motivo' => $data['motivo'],
            ':estado' => $data['estado'],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CAMBIAR ESTADO
    |--------------------------------------------------------------------------
    */

    public function updateEstado($id, $estado)
    {
        $sql = "UPDATE citas
            SET estado = :estado
            WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':estado' => $estado,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR CITA
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        $sql = "DELETE FROM citas
            WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
        ]);
    }
}
