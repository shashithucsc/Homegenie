<?php 


class carpentryPageModel {
    private $db;

    public function __construct() {
     
        $this->db = new Database();
    }

    public function getCarpentryItems() {
        $this->db->query("SELECT * FROM inventory where category = 'Carpentry'");

        $results = $this->db->resultset();

        return $results;

    }    
       
}
