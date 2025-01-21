<?php 


class paintingPageModel {
    private $db;

    public function __construct() {
     
        $this->db = new Database();
    }

    public function getPaintingItems() {
        $this->db->query("SELECT * FROM inventory where category = 'Painting'");

        $results = $this->db->resultset();

        return $results;

    }    
       
}
