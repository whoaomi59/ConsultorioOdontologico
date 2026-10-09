<?php
class Consultorio {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener los datos del consultorio
    public function getInfo() {
        $query = "SELECT * FROM consultorio LIMIT 1";
        $stmt  = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todas las convenciones registradas
    public function getConvenciones() {
        $query = "SELECT * FROM convenciones ORDER BY id ASC";
        $stmt  = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}