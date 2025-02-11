<?php

class CustomerModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getServiceProviders() {
        $this->db->query("SELECT * FROM users WHERE role = 'service_provider'");
        return $this->db->resultSet();
    }
}
?>