<?php
class SupplierModel {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Assumes a Database class exists for handling DB operations
    }

    public function getTotalSales($userId) {
        $this->db->query("SELECT SUM(total_amount) AS total_sales FROM sales WHERE user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        $results = $this->db->resultSet();
        return $results;
    }

    public function getTotalCustomers($userId) {
        $this->db->query("
            SELECT COUNT(DISTINCT user_id) AS total_customers 
            FROM sales 
            WHERE user_id = :user_id
        ");
        $this->db->bind(':user_id', $userId);
        $results = $this->db->resultSet();
        return $results;
    }

    public function getTotalProducts($userId) {
        $this->db->query("SELECT COUNT(item_id) AS total_products FROM inventory WHERE user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        $results = $this->db->resultSet();
        return $results;
    }

    public function getTopCategory($userId) {
        $this->db->query("
            SELECT i.category, SUM(si.quantity) AS total_sold
            FROM sales_items si
            JOIN inventory i ON si.item_id = i.item_id
            JOIN sales s ON si.sale_id = s.id
            WHERE s.user_id = :user_id
            GROUP BY i.category
            ORDER BY total_sold DESC
            LIMIT 1
        ");
        $this->db->bind(':user_id', $userId);
        $results = $this->db->resultSet();
        return $results;
    }

    public function getTopProduct($userId) {
        $this->db->query("
            SELECT i.item_name, SUM(si.quantity) AS total_sold
            FROM sales_items si
            JOIN inventory i ON si.item_id = i.item_id
            JOIN sales s ON si.sale_id = s.id
            WHERE s.user_id = :user_id
            GROUP BY si.item_id
            ORDER BY total_sold DESC
            LIMIT 1
        ");
        $this->db->bind(':user_id', $userId);
        $results = $this->db->resultSet();
        return $results;
    }

     // Fetch overall inventory statistics grouped by category
     public function getInventoryReport($userId) {
        $this->db->query("
            SELECT 
                i.category,
                SUM(i.quantity) AS total_items,
                IFNULL(SUM(si.quantity), 0) AS sold_items,
                SUM(i.quantity) - IFNULL(SUM(si.quantity), 0) AS remaining_stock,
                SUM(i.quantity * i.selling_price) AS total_value
            FROM inventory i
            LEFT JOIN sales_items si ON i.item_id = si.item_id
            JOIN sales s ON si.sale_id = s.id
            WHERE i.user_id = :user_id
            GROUP BY i.category
        ");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    
    // Fetch sales report (item-level sales and revenue)
    public function getSalesReport($userId) {
        $this->db->query("
            SELECT 
                i.item_name,
                SUM(si.quantity) AS sold_quantity,
                SUM(si.price * si.quantity) AS revenue
            FROM sales_items si
            JOIN inventory i ON si.item_id = i.item_id
            JOIN sales s ON si.sale_id = s.id
            WHERE i.user_id = :user_id
            GROUP BY si.item_id
        ");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    // Fetch reorder suggestions for inventory
    public function getReorderSuggestions($userId) {
        $this->db->query("
            SELECT 
                i.item_name,
                i.quantity AS current_stock,
                :default_threshold - i.quantity AS reorder_quantity,
                (:default_threshold - i.quantity) * i.selling_price AS suggested_order_value
            FROM inventory i
            WHERE i.user_id = :user_id AND i.quantity < :default_threshold
        ");
        $this->db->bind(':default_threshold', 20); // Default threshold value (e.g., 20 units)
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    
}
