<?php
class InventoryModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllItems($userId) {
        $this->db->query("SELECT * FROM inventory WHERE user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        $results = $this->db->resultSet();
        return $results;
    }

    public function addItem($data) {
        $this->db->query(
            "INSERT INTO inventory (item_name, quantity, selling_price, category, added_date, image_path) 
            VALUES (:item_name, :quantity, :selling_price, :category, :added_date, :image)"
        );
        $this->db->bind(':item_name', $data['item_name']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':selling_price', $data['selling_price']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':added_date', $data['added_date']);
        $this->db->bind(':image', $data['image']);
        
        return $this->db->execute();
    }
    

    public function updateItemDetails($data) {
        $this->db->query("UPDATE inventory SET selling_price = :price, quantity = :quantity WHERE item_id = :item_id");
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':item_id', $data['item_id']);
        return $this->db->execute();
    }
    

    public function deleteItem($itemId) {
        $this->db->query("DELETE FROM inventory WHERE item_id = :item_id");
        $this->db->bind(':item_id', $itemId);
        return $this->db->execute();
    }


    
}
?>
