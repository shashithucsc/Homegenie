<?php
class ExpertiseModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllExpertise() {
        $this->db->query('SELECT * FROM expertise ORDER BY expertise_name');
        return $this->db->resultSet();
    }
}