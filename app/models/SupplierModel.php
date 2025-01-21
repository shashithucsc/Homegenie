<?php
class SupplierModel {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Assumes a Database class exists for handling DB operations
    }

    public function getTotalSales() {
        $this->db->query("SELECT SUM(total_amount) AS total_sales FROM sales");
        $results = $this->db->resultSet();
        return $results;
    }
    
    public function getTotalCustomers() {
        $this->db->query("SELECT COUNT(DISTINCT user_id) AS total_customers FROM sales");
        $results = $this->db->resultSet();
        return $results;
    }
    
    public function getTotalProducts() {
        $this->db->query("SELECT COUNT(item_id) AS total_products FROM inventory");
        $results = $this->db->resultSet();
        return $results;
    }
    
    public function getTopCategory() {
        $this->db->query("
            SELECT i.category, SUM(si.quantity) AS total_sold
            FROM sales_items si
            JOIN inventory i ON si.item_id = i.item_id
            GROUP BY i.category
            ORDER BY total_sold DESC
            LIMIT 1
        ");
        $results = $this->db->resultSet();
        return $results;
    }
    
    public function getTopProduct() {
        $this->db->query("
            SELECT i.item_name, SUM(si.quantity) AS total_sold
            FROM sales_items si
            JOIN inventory i ON si.item_id = i.item_id
            GROUP BY si.item_id
            ORDER BY total_sold DESC
            LIMIT 1
        ");
        $results = $this->db->resultSet();
        return $results;
    }
    
}
