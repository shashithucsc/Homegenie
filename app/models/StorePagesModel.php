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
                u.first_name AS supplier_name,
                u.user_id AS supplier_id
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
    public function saveItem($user_id, $item_id)
    {
        // First, check if item already exists in wishlist
        $this->db->query('SELECT * FROM saved_items WHERE user_id = :user_id AND item_id = :item_id');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':item_id', $item_id);
        $this->db->execute();
    
        if ($this->db->rowCount() > 0) {
            return 'exists';
        }
    
        // If not exists, insert the item
        $this->db->query('INSERT INTO saved_items (user_id, item_id) VALUES (:user_id, :item_id)');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':item_id', $item_id);
    
        if ($this->db->execute()) {
            return 'saved';
        } else {
            return false;
        }
    }
    

    public function removeSavedItem($user_id, $item_id) {
        $this->db->query('DELETE FROM saved_items WHERE item_id = :item_id AND user_id = :user_id');
        $this->db->bind(':item_id', $item_id);
        $this->db->bind(':user_id', $user_id);
        return $this->db->execute();
    }
    
    public function getSavedItem($user_id) {
        $this->db->query('
            SELECT 
                saved_items.*, 
                inventory.item_name, 
                inventory.selling_price, 
                inventory.image_path, 
                users.first_name AS supplier_name 
            FROM saved_items
            JOIN inventory ON saved_items.item_id = inventory.item_id
            JOIN users ON inventory.user_id = users.user_id
            WHERE saved_items.user_id = :user_id
        ');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function getMyorders($customer_id){
        $this->db->query("SELECT * FROM sales_orders WHERE customer_id = :customer_id ORDER BY created_at DESC");
        $this->db->bind(':customer_id', $customer_id);
        return $this->db->resultSet();
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
