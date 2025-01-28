<?php
class SupplierModel {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Assumes a Database class exists for handling DB operations
    }

    public function getTotalSales($userId) {
        $this->db->query("SELECT SUM(total_amount) AS total_sales FROM sales WHERE supplier_id = :user_id");
        $this->db->bind(':user_id', $userId); // Make sure you use supplier_id here
        $results = $this->db->resultSet();
        return $results;
    }
    

    public function getTotalCustomers($userId) {
        $this->db->query("SELECT COUNT(DISTINCT customer_id) AS total_customers FROM sales WHERE supplier_id = :user_id");
        $this->db->bind(':user_id', $userId); // Make sure you use supplier_id here
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
            WHERE s.supplier_id = :user_id
            GROUP BY i.category
            ORDER BY total_sold DESC
            LIMIT 1
        ");
        $this->db->bind(':user_id', $userId); // Make sure you use supplier_id here
        $results = $this->db->resultSet();
        return $results;
    }
    

    public function getTopProduct($userId) {
        $this->db->query("
            SELECT i.item_name, SUM(si.quantity) AS total_sold
            FROM sales_items si
            JOIN inventory i ON si.item_id = i.item_id
            JOIN sales s ON si.sale_id = s.id
            WHERE s.supplier_id = :user_id
            GROUP BY si.item_id
            ORDER BY total_sold DESC
            LIMIT 1
        ");
        $this->db->bind(':user_id', $userId); // Make sure you use supplier_id here
        $results = $this->db->resultSet();
        return $results;
    }
    

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
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':default_threshold', 50);  // Example threshold
        return $this->db->resultSet();
    }

    public function getSupplierById($userId) {
        $this->db->query("SELECT * FROM suppliers WHERE supplier_id = :user_id");
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        return $result;
    }

    public function getProductsBySupplierId($userId) {
        $this->db->query("SELECT * FROM inventory WHERE user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function getPendingOrders($supplierId)
{
    // Query to fetch pending orders
    $this->db->query(
        "SELECT 
            so.id AS order_id,
            so.customer_id,
            so.total_amount,
            so.payment_method,
            so.delivery_address,
            so.created_at,
            si.item_id,
            si.quantity,
            si.price,
            u.first_name AS customer_name,
            u.contact_number,
            u.email
         FROM 
            sales_orders so
         JOIN 
            sales_items si ON so.id = si.sale_id
         JOIN 
            users u ON so.customer_id = u.user_id
         WHERE 
            so.supplier_id = :supplier_id AND si.status = 'Pending'
         ORDER BY 
            so.created_at DESC"
    );

    // Bind the supplier ID
    $this->db->bind(':supplier_id', $supplierId);

    // Return the result set, defaulting to an empty array if null
    return $this->db->resultSet() ?? [];
}

public function updateOrderStatus($orderId, $status)
{
    // Update the status of the sales order
    $this->db->query("UPDATE sales_orders SET status = :status WHERE id = :order_id");
    $this->db->bind(':status', $status);
    $this->db->bind(':order_id', $orderId);
    
    // Execute the update for the sales_orders table
    $this->db->execute();

    // Update the status of the sales items associated with the order
    $this->db->query("UPDATE sales_items SET status = :status WHERE sale_id = :order_id");
    $this->db->bind(':status', $status);
    $this->db->bind(':order_id', $orderId);

    // Execute the update for the sales_items table
    return $this->db->execute();
}


}
