<?php
class CartModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAvailableQuantity($itemId) {
        $this->db->query("SELECT quantity FROM inventory WHERE item_id = :item_id");
        $this->db->bind(':item_id', $itemId);
        return $this->db->single()->quantity;
    }

    public function getSupplierIdByItemId($itemId) {
        // Get the user_id (supplier_id) from the inventory table
        $this->db->query("SELECT user_id FROM inventory WHERE item_id = :item_id");
        $this->db->bind(':item_id', $itemId);
        $result = $this->db->single();
        
        // Return user_id as the supplier_id if found, else null
        return $result ? $result->user_id : null; // Using user_id as supplier_id
    }
    
    

    public function addItemToCart($userId, $itemId, $quantity,$supplierId) {
        $this->db->query("INSERT INTO cart (user_id, item_id, quantity, supplier_id) VALUES (:user_id, :item_id, :quantity, :supplier_id)");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':item_id', $itemId);
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':supplier_id', $supplierId);
        return $this->db->execute();
    }

    public function updateInventoryLevel($itemId, $newQuantity) {
        $this->db->query("UPDATE inventory SET quantity = :new_quantity WHERE item_id = :item_id");
        $this->db->bind(':new_quantity', $newQuantity);
        $this->db->bind(':item_id', $itemId);
        return $this->db->execute();
    }

    public function getCartItemsByUserId($userId) {
        $this->db->query("
            SELECT 
                cart.id,
                cart.item_id,
                inventory.item_name,
                inventory.selling_price,
                cart.created_at,
                cart.user_id,
                cart.quantity,
                cart.supplier_id,
                inventory.quantity AS available_quantity
            FROM cart
            JOIN inventory ON cart.item_id = inventory.item_id
            WHERE cart.user_id = :user_id
        ");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function removeItemFromCart($cartItemId) {
        $this->db->query("DELETE FROM cart WHERE id = :cart_item_id");
        $this->db->bind(':cart_item_id', $cartItemId);
        return $this->db->execute();
    }

    public function updateCartQuantity($cartItemId, $newQuantity) {
        $this->db->query("UPDATE cart SET quantity = :quantity WHERE id = :cart_item_id");
        $this->db->bind(':quantity', $newQuantity);
        $this->db->bind(':cart_item_id', $cartItemId);
        return $this->db->execute();
    }

    public function getCartItemById($cartItemId) {
        $this->db->query("SELECT * FROM cart WHERE id = :cart_item_id");
        $this->db->bind(':cart_item_id', $cartItemId);
        return $this->db->single();
    }
    
    // Create an order
    public function createOrder($userId, $totalAmount, $paymentMethod, $deliveryAddress) {
        $this->db->query("
            INSERT INTO sales (user_id, total_amount, payment_method, delivery_address, supplier_id) 
            VALUES (:user_id, :total_amount, :payment_method, :delivery_address, :supplier_id)
        ");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':total_amount', $totalAmount);
        $this->db->bind(':payment_method', $paymentMethod);
        $this->db->bind(':delivery_address', $deliveryAddress);
        $this->db->bind(':supplier_id', $supplierId);
    
        if ($this->db->execute()) {
            return $this->db->lastInsertId(); // Get the ID of the inserted order
        }
        return false; // Return false if the query fails
    }
    

   // Add item to order
public function addOrderItem($saleId, $itemId, $quantity, $price,$supplierId) {
    $this->db->query("
        INSERT INTO sales_items (sale_id, item_id, quantity, price,supplier_id)
        VALUES (:sale_id, :item_id, :quantity, :price, :supplier_id)
    ");
    $this->db->bind(':sale_id', $saleId);  // Use sale_id instead of order_id
    $this->db->bind(':item_id', $itemId);
    $this->db->bind(':quantity', $quantity);
    $this->db->bind(':price', $price);
    $this->db->bind(':supplier_id', $supplierId);
    return $this->db->execute();
}


    // Clear the cart
    public function clearCart($userId) {
        $this->db->query("DELETE FROM cart WHERE user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }
    
}
