<?php 


class electricityPageModel {
    private $db;

    public function __construct() {
     
        $this->db = new Database();
    }

    public function getElectricityItems() {
        $this->db->query("SELECT * FROM inventory where category = 'Electricity'");

        $results = $this->db->resultset();

        return $results;

    }    
       
}
