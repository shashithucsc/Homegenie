<?php 


class cleaningPageModel {
    private $db;

    public function __construct() {
     
        $this->db = new Database();
    }

    public function getCleaningItems() {
        $this->db->query("SELECT * FROM inventory where category = 'Cleaning'");

        $results = $this->db->resultset();

        return $results;

    }    
       
}
