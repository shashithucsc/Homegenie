<?php
class SupplierModel {
    private $db;

    public function __construct() {
        $this->db = new Database(); 
    }



    public function getTotalSales($userId) {
        $this->db->query("SELECT SUM(total_amount) AS total_sales 
                          FROM sales_orders
                          WHERE supplier_id = :user_id 
                          AND status = 'Accepted'");
        $this->db->bind(':user_id', $userId); 
        $results = $this->db->resultSet();
        return $results;
    }
    
    

    public function getTotalCustomers($userId) {
        $this->db->query("SELECT COUNT(DISTINCT customer_id) AS total_customers FROM sales_orders WHERE supplier_id = :user_id");
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

    public function getYourEarnings($userId) {
        $this->db->query("SELECT ROUND(SUM(total_amount) * 0.9, 2) AS yourEarnings 
                          FROM sales_orders
                          WHERE supplier_id = :user_id 
                          AND status = 'Accepted'");
        $this->db->bind(':user_id', $userId); 
        $results = $this->db->single();
        return $results;
    }
    
    

    public function getTopProduct($userId) {
        $this->db->query("SELECT i.item_name, SUM(si.quantity) AS total_sold
                          FROM sales_items si
                          JOIN inventory i ON si.item_id = i.item_id
                          JOIN sales_orders so ON si.sale_id = so.id
                          WHERE so.supplier_id = :user_id
                          AND si.status = 'Accepted'
                          AND so.status = 'Accepted'
                          GROUP BY si.item_id
                          ORDER BY total_sold DESC
                          LIMIT 1");
        $this->db->bind(':user_id', $userId); 
        $results = $this->db->resultSet();
        return $results;
    }

    public function getPendingOrdersCount($userId) {
        $this->db->query("SELECT COUNT(*) AS pending_orders_count 
                          FROM sales_orders 
                          WHERE supplier_id = :supplier_id 
                          AND status = 'Pending'");
        $this->db->bind(':supplier_id', $userId); 
        $result = $this->db->single();
        return $result ? $result->pending_orders_count : 0;
    }

    public function getCompletedOrdersCount($userId) {
        $this->db->query("SELECT COUNT(*) AS completed_orders_count 
                          FROM sales_orders 
                          WHERE supplier_id = :supplier_id 
                          AND status = 'Accepted'");
        $this->db->bind(':supplier_id', $userId); 
        $result = $this->db->single();
        return $result ? $result->completed_orders_count : 0;
    }
    
    

    public function getInventoryReport($userId) {
        $this->db->query("
            SELECT 
                i.category,
                SUM(i.quantity) AS total_items,
                IFNULL(SUM(si.quantity), 0) AS sold_items,
                SUM(i.quantity) - IFNULL(SUM(si.quantity), 0) AS remaining_stock,
                IFNULL(SUM(i.quantity * i.selling_price), 0) AS total_value
            FROM inventory i
            LEFT JOIN sales_items si ON i.item_id = si.item_id
            LEFT JOIN sales_orders s ON si.sale_id = s.id
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
            JOIN sales_orders s ON si.sale_id = s.id
            WHERE s.status = 'Accepted' 
            AND i.user_id = :user_id
            GROUP BY si.item_id
        ");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    

   

    public function getProductsBySupplierId($userId) {
        $this->db->query("SELECT * FROM inventory WHERE user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function getPendingOrders($supplierId)
{
    
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
            i.item_name, 
            u.first_name AS customer_name,
            u.contact_number,
            u.email
         FROM 
            sales_orders so
         JOIN 
            sales_items si ON so.id = si.sale_id
         JOIN 
            inventory i ON si.item_id = i.item_id 
         JOIN 
            users u ON so.customer_id = u.user_id
         WHERE 
            so.supplier_id = :supplier_id AND si.status = 'Pending'
         ORDER BY 
            so.created_at DESC"
    );

    
    $this->db->bind(':supplier_id', $supplierId);

   
    return $this->db->resultSet() ?? [];
}


public function updateOrderStatus($orderId, $status)
{
   
    $this->db->query("UPDATE sales_orders SET status = :status WHERE id = :order_id");
    $this->db->bind(':status', $status);
    $this->db->bind(':order_id', $orderId);

  
    $this->db->execute();

   
    $this->db->query("UPDATE sales_items SET status = :status WHERE sale_id = :order_id");
    $this->db->bind(':status', $status);
    $this->db->bind(':order_id', $orderId);

   
    return $this->db->execute();
}


public function getCompletedOrders($supplierId)
{
   
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
            i.item_name, 
            u.first_name AS customer_name,
            u.contact_number,
            u.email
         FROM 
            sales_orders so
         JOIN 
            sales_items si ON so.id = si.sale_id
         JOIN 
            inventory i ON si.item_id = i.item_id 
         JOIN 
            users u ON so.customer_id = u.user_id
         WHERE 
            so.supplier_id = :supplier_id AND si.status = 'Accepted'
         ORDER BY 
            so.created_at DESC"
    );

    
    $this->db->bind(':supplier_id', $supplierId);

  
    return $this->db->resultSet() ?? [];
}


public function getSupplierById($userId) {
    $sql = "SELECT u.user_id, u.first_name, u.last_name, u.contact_number, u.email, 
                   u.street, u.district, u.province, u.profile_image, u.role,
                   s.expertise, s.description, s.NIC, s.id_front_photo, s.id_back_photo, s.bank_details
            FROM users u
            LEFT JOIN suppliers s ON u.user_id = s.user_id
            WHERE u.user_id = :user_id";
    $this->db->query($sql);
    $this->db->bind(':user_id', $userId);
    return $this->db->single();
}


public function getProductsBySupplier($userId) {
    $sql = "SELECT * FROM inventory WHERE user_id = :user_id";
    $this->db->query($sql);
    $this->db->bind(':user_id', $userId);
    return $this->db->resultSet();
}


public function updateSupplierProfile($data) {
   
    $sql = "UPDATE users
            SET first_name = :first_name, 
                last_name = :last_name, 
                contact_number = :contact_number, 
                street = :street,
                district = :district,
                province = :province
            WHERE user_id = :user_id";
    $this->db->query($sql);

   
    $this->db->bind(':first_name', $data['first_name']);
    $this->db->bind(':last_name', $data['last_name']);
    $this->db->bind(':contact_number', $data['contact_number']);
    $this->db->bind(':street', $data['street']);
    $this->db->bind(':district', $data['district']);
    $this->db->bind(':province', $data['province']);
    $this->db->bind(':user_id', $data['user_id']);
    $this->db->execute();

    
    $sql = "UPDATE suppliers
            SET expertise = :expertise, 
                description = :description,
                NIC = :NIC,
                bank_details = :bank_details
            WHERE user_id = :user_id";
    $this->db->query($sql);

    $this->db->bind(':expertise', $data['expertise']);
    $this->db->bind(':description', $data['description']);
    $this->db->bind(':NIC', $data['NIC']);
    $this->db->bind(':bank_details', $data['bank_details']);
    $this->db->bind(':user_id', $data['user_id']);

    return $this->db->execute();
}


public function updateProfilePicture($userId, $profileImage) {
    $sql = "UPDATE users SET profile_image = :profile_image WHERE user_id = :user_id";
    $this->db->query($sql);

    $this->db->bind(':profile_image', $profileImage, PDO::PARAM_LOB);
    $this->db->bind(':user_id', $userId);

    return $this->db->execute();
}


}
