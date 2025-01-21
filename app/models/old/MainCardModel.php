<?php

class MainCardModel {
    private $db;

    public function __construct() {
        $this->db = new Database(); 
    }

    public function getPlumbingItems() {
        $this->db->query("SELECT * FROM inventory where category = 'Plumbing'");
        
        
        $results = $this->db->resultset();
       
       
    
       return $results;
    }
    
}
