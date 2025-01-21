<?php 


class masonaryPageModel {
    private $db;

    public function __construct() {
     
        $this->db = new Database();
    }

    public function getMasonaryItems() {
        $this->db->query("SELECT * FROM inventory where category = 'Masonary'");

        $results = $this->db->resultset();

        return $results;

    }    
       
}
