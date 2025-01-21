<?php

class StorePagesModel {
    private $db;

    public function __construct() {
        $this->db = new Database(); 
    }


    //fetch cards for store pages
    public function getPlumbingItems() {
        $this->db->query("SELECT * FROM inventory where category = 'Plumbing'");
        $results = $this->db->resultset();
       return $results;
    }

    public function getCarpentryItems() {
        $this->db->query("SELECT * FROM inventory where category = 'Carpentry'");
        $results = $this->db->resultset();
        return $results;

    }
    public function getCleaningItems() {
        $this->db->query("SELECT * FROM inventory where category = 'Cleaning'");
        $results = $this->db->resultset();
        return $results;

    } 
    
    public function getElectricityItems() {
        $this->db->query("SELECT * FROM inventory where category = 'Electricity'");
        $results = $this->db->resultset();
        return $results;

    }

    public function getMasonaryItems() {
        $this->db->query("SELECT * FROM inventory where category = 'Masonary'");
        $results = $this->db->resultset();
        return $results;

    }

    public function getPaintingItems() {
        $this->db->query("SELECT * FROM inventory where category = 'Painting'");
        $results = $this->db->resultset();
        return $results;

    }
    
    
    
    
    
    
    //seasonal offers section
    public function getSeasonalOffers() {
        $query = "SELECT id, description, image FROM seasonal_offers";
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }

    public function addSeasonalOffer($description, $image) {
        $query = "INSERT INTO seasonal_offers (description, image) VALUES (:description, :image)";
        $this->db->query($query);
        $this->db->bind(':description', $description);
        $this->db->bind(':image', $image);
        return $this->db->execute();
    }

    public function updateSeasonalOffer($id, $description, $image) {
        $query = "UPDATE seasonal_offers SET description = :description" .
                 ($image ? ", image = :image" : "") . 
                 " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':description', $description);
        $this->db->bind(':id', $id);
        if ($image) {
            $this->db->bind(':image', $image);
        }
        return $this->db->execute();
    }

    public function deleteSeasonalOffer($id) {
        $query = "DELETE FROM seasonal_offers WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    //wishlist section
    public function saveItem($item_id, $user_id) {
        $this->db->query('INSERT INTO wishlist (user_id, item_id) VALUES (:user_id, :item_id)');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':item_id', $item_id);
        return $this->db->execute();
    }

    
    
    
    


    
}
