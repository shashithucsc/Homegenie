<?php
class WishlistModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function saveItem($item_id, $user_id) {
        $this->db->query('INSERT INTO wishlist (user_id, item_id) VALUES (:user_id, :item_id)');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':item_id', $item_id);
        return $this->db->execute();
    }
}
?>
