<?php
class OrderModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    public function getOrderCounts() {
        return [
            'pastWeek' => $this->getOrdersCountPastWeek(),
            'all' => $this->getTotalOrdersCount()
        ];
    }
    
    public function getOrdersByStatus() {
        $this->db->query("SELECT status, COUNT(*) as count FROM sales_orders GROUP BY status");
        return $this->db->resultSet();
    }
    
    private function getOrdersCountPastWeek() {
        $this->db->query("SELECT COUNT(*) as count FROM sales_orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
        return $this->db->single()->count;
    }
    
    private function getTotalOrdersCount() {
        $this->db->query("SELECT COUNT(*) as count FROM sales_orders");
        return $this->db->single()->count;
    }
    
    public function getRevenueData() {
        // Calculate monthly revenue (5% of all orders) for the past 7 months
        $this->db->query("SELECT 
                            MONTH(created_at) as month, 
                            SUM(total_amount * 0.05) as revenue 
                          FROM sales_orders 
                          WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 MONTH)
                          GROUP BY MONTH(created_at)
                          ORDER BY month ASC");
        
        $results = $this->db->resultSet();
        
        // Format data for the chart
        $data = array_fill(0, 7, 0); // Initialize with zeros
        
        foreach($results as $row) {
            $monthIndex = (intval($row->month) - 1) % 7; // Adjust month to 0-based index
            $data[$monthIndex] = $row->revenue;
        }
        
        return $data;
    }
    
    public function getTotalRevenue() {
        $this->db->query("SELECT SUM(total_amount * 0.05) as total_revenue FROM sales_orders");
        $result = $this->db->single();
        return $result->total_revenue ?? 0;
    }

    public function getOrders() {
        $this->db->query("SELECT * FROM sales_orders");
        return $this->db->resultSet();
    }
}