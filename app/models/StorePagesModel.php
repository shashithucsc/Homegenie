<?php

class StorePagesModel {
    private $db;

    public function __construct() {
        $this->db = new Database(); 
    }


    //fetch cards for store pages
    public function getPlumbingItems() {
        $query = "
            SELECT 
                i.item_id,
                i.item_name,
                i.quantity,
                i.selling_price,
                i.category,
                i.image_path,
                u.first_name AS supplier_name
            FROM 
                inventory i
            JOIN 
                users u ON i.user_id = u.user_id
            WHERE 
                i.category = 'Plumbing'";
        $this->db->query($query);
        $results = $this->db->resultset();
        return $results;
    }
    

    public function getCarpentryItems() {
        $this->db->query("SELECT 
                i.item_id,
                i.item_name,
                i.quantity,
                i.selling_price,
                i.category,
                i.image_path,
                u.first_name AS supplier_name
            FROM 
                inventory i
            JOIN 
                users u ON i.user_id = u.user_id
            WHERE 
                i.category = 'Carpentry'");
        $results = $this->db->resultset();
        return $results;

    }
    public function getCleaningItems() {
        $this->db->query("SELECT 
                i.item_id,
                i.item_name,
                i.quantity,
                i.selling_price,
                i.category,
                i.image_path,
                u.first_name AS supplier_name
            FROM 
                inventory i
            JOIN 
                users u ON i.user_id = u.user_id
            WHERE 
                i.category = 'Cleaning'");
        $results = $this->db->resultset();
        return $results;

    } 
    
    public function getElectricityItems() {
        $this->db->query("SELECT 
                i.item_id,
                i.item_name,
                i.quantity,
                i.selling_price,
                i.category,
                i.image_path,
                u.first_name AS supplier_name
            FROM 
                inventory i
            JOIN 
                users u ON i.user_id = u.user_id
            WHERE 
                i.category = 'Electricity'");
        $results = $this->db->resultset();
        return $results;

    }

    public function getMasonaryItems() {
        $this->db->query("SELECT 
                i.item_id,
                i.item_name,
                i.quantity,
                i.selling_price,
                i.category,
                i.image_path,
                u.first_name AS supplier_name
            FROM 
                inventory i
            JOIN 
                users u ON i.user_id = u.user_id
            WHERE 
                i.category = 'Masonary'");
        $results = $this->db->resultset();
        return $results;

    }

    public function getPaintingItems() {
        $this->db->query("SELECT 
                i.item_id,
                i.item_name,
                i.quantity,
                i.selling_price,
                i.category,
                i.image_path,
                u.first_name AS supplier_name
            FROM 
                inventory i
            JOIN 
                users u ON i.user_id = u.user_id
            WHERE 
                i.category = 'Painting'");
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

    public function searchItems($searchQuery) {
        $this->db->query("SELECT i.*, u.first_name AS supplier_name 
                          FROM inventory i
                          LEFT JOIN users u ON i.user_id = u.user_id
                          WHERE i.item_name LIKE :searchQuery 
                          OR i.category LIKE :searchQuery");
        $this->db->bind(':searchQuery', '%' . $searchQuery . '%');
        return $this->db->resultSet();
    }
    

    
    
    
    


    
}
