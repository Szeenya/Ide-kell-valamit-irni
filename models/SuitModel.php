<?php
class SuitModel {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function getAllSuits() {
        $sql = "SELECT * FROM suits";
        $result = $this->db->query($sql);
        $suits = [];
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $suits[] = $row;
            }
        }
        
        return $suits;
    }
}