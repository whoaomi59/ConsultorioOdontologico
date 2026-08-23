<?php
class Consultorio {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtener los datos del consultorio (generalmente es el primer registro o único ID = 1)
    public function getInfo() {
        $query = "SELECT * FROM consultorio LIMIT 1";
        $stmt  = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}