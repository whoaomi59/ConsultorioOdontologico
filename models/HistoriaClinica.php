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

    // Obtener la historia clínica base del paciente
    public function getBaseByPacienteId($paciente_id) {
        $sql  = "SELECT * FROM historias_clinicas_base WHERE paciente_id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$paciente_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Guardar o actualizar la historia clínica base (se llena una sola vez)
    public function saveBase($data) {
        $existente = $this->getBaseByPacienteId($data['paciente_id']);

        if ($existente) {
            $sql = "UPDATE historias_clinicas_base SET
                alerta_medica = ?, ant_hipertension = ?, ant_traumas = ?, ant_cirugias = ?,
                ant_hepatitis = ?, ant_convulsiones = ?, ant_alergias = ?, ant_hipoglicemia_diabetes = ?,
                ant_gastritis_resp = ?, ant_t_mentales = ?, ant_enf_cardiovascular = ?, ant_cancer = ?,
                ant_embarazo = ?, ant_fiebre_reumatica = ?, ant_sida = ?, ant_otras = ?,
                higiene_cepillado = ?, higiene_cepillado_cant = ?, higiene_seda = ?, higiene_seda_cant = ?,
                higiene_enjuague = ?, higiene_enjuague_cant = ?, higiene_otro = ?, higiene_otro_cual = ?,
                examen_estomatologico = ?, acudiente_nombre = ?, acudiente_documento = ?, acudiente_parentesco = ?
                WHERE paciente_id = ?";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['alerta_medica'],
                $data['ant_hipertension'],
                $data['ant_traumas'],
                $data['ant_cirugias'],
                $data['ant_hepatitis'],
                $data['ant_convulsiones'],
                $data['ant_alergias'],
                $data['ant_hipoglicemia_diabetes'],
                $data['ant_gastritis_resp'],
                $data['ant_t_mentales'],
                $data['ant_enf_cardiovascular'],
                $data['ant_cancer'],
                $data['ant_embarazo'],
                $data['ant_fiebre_reumatica'],
                $data['ant_sida'],
                $data['ant_otras'],
                $data['higiene_cepillado'],
                $data['higiene_cepillado_cant'],
                $data['higiene_seda'],
                $data['higiene_seda_cant'],
                $data['higiene_enjuague'],
                $data['higiene_enjuague_cant'],
                $data['higiene_otro'],
                $data['higiene_otro_cual'],
                $data['examen_estomatologico'],
                $data['acudiente_nombre'],
                $data['acudiente_documento'],
                $data['acudiente_parentesco'],
                $data['paciente_id'] // <-- Este parámetro faltaba al final para cerrar el WHERE paciente_id = ?
            ]);
        } else {
            $sql = "INSERT INTO historias_clinicas_base (
                paciente_id, alerta_medica, ant_hipertension, ant_traumas, ant_cirugias, ant_hepatitis,
                ant_convulsiones, ant_alergias, ant_hipoglicemia_diabetes, ant_gastritis_resp, ant_t_mentales,
                ant_enf_cardiovascular, ant_cancer, ant_embarazo, ant_fiebre_reumatica, ant_sida, ant_otras,
                higiene_cepillado, higiene_cepillado_cant, higiene_seda, higiene_seda_cant, higiene_enjuague,
                higiene_enjuague_cant, higiene_otro, higiene_otro_cual, examen_estomatologico,
                acudiente_nombre, acudiente_documento, acudiente_parentesco
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['paciente_id'], $data['alerta_medica'], $data['ant_hipertension'], $data['ant_traumas'], $data['ant_cirugias'], $data['ant_hepatitis'],
                $data['ant_convulsiones'], $data['ant_alergias'], $data['ant_hipoglicemia_diabetes'], $data['ant_gastritis_resp'], $data['ant_t_mentales'],
                $data['ant_enf_cardiovascular'], $data['ant_cancer'], $data['ant_embarazo'], $data['ant_fiebre_reumatica'], $data['ant_sida'], $data['ant_otras'],
                $data['higiene_cepillado'], $data['higiene_cepillado_cant'], $data['higiene_seda'], $data['higiene_seda_cant'], $data['higiene_enjuague'],
                $data['higiene_enjuague_cant'], $data['higiene_otro'], $data['higiene_otro_cual'], $data['examen_estomatologico'],
                $data['acudiente_nombre'], $data['acudiente_documento'], $data['acudiente_parentesco']
            ]);
        }
    }

    // Trae las evoluciones/consultas del paciente
    public function getByPacienteId($paciente_id) {
        $sql = "SELECT h.*, u.nombre AS doctor_nombre, u.email AS doctor_email
            FROM historias_clinicas h
            LEFT JOIN usuarios u ON h.usuario_id = u.id
            WHERE h.paciente_id = ?
            ORDER BY h.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$paciente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Guarda una nueva consulta (evolución + odontograma) cada vez que vuelve
    public function create($data) {
        $sql = "INSERT INTO historias_clinicas (
            paciente_id, usuario_id, motivo_consulta, diagnostico, tratamiento,
            observaciones, odontograma, firma_base64
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['paciente_id'],
            $data['usuario_id'],
            $data['motivo_consulta'],
            $data['diagnostico'],
            $data['tratamiento'],
            $data['observaciones'],
            $data['odontograma'],
            $data['firma_base64']
        ]);
    }
}
?>