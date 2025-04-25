<?php
class UserModel {
    public $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function registerUser($data) {
        try {
            // For customers, we'll use a different query without profile_image
            if ($data['role'] === 'customer') {
                $this->db->query('INSERT INTO users (first_name, last_name, contact_number, email, province, district, street, password, role, agree_terms) 
                    VALUES (:first_name, :last_name, :contact_number, :email, :province, :district, :street, :password, :role, :agree_terms)');
            } else {
                $this->db->query('INSERT INTO users (first_name, last_name, contact_number, email, province, district, street, profile_image, password, role, agree_terms) 
                    VALUES (:first_name, :last_name, :contact_number, :email, :province, :district, :street, :profile_image, :password, :role, :agree_terms)');
                $this->db->bind(':profile_image', $data['profile_image'], PDO::PARAM_LOB);
            }
        
            // Bind common user data
            $this->db->bind(':first_name', $data['first_name']);
            $this->db->bind(':last_name', $data['last_name']);
            $this->db->bind(':contact_number', $data['contact_number']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':province', $data['province']);
            $this->db->bind(':district', $data['district']);
            $this->db->bind(':street', $data['street']);
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':role', $data['role']);
            $this->db->bind(':agree_terms', $data['agree_terms']);
        
            if ($this->db->execute()) {
                return $this->db->lastInsertId();
            } else {
                error_log("Failed to execute user registration query");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database error in registerUser: " . $e->getMessage());
            return false;
        }
    }
    public function registerCustomer($userId) {
        try {
            $this->db->query('INSERT INTO customers (customer_id) VALUES (:customer_id)');
            $this->db->bind(':customer_id', $userId);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Customer Registration Error: " . $e->getMessage());
            return false;
        }
    }
    

    // Register supplier-specific data
    public function registerSupplier($userId, $supplierData) {
        try {
            $this->db->query('INSERT INTO suppliers(user_id, expertise, NIC, id_front_photo, id_back_photo, bank_details) 
                VALUES (:user_id, :expertise, :NIC, :id_front_photo, :id_back_photo, :bank_details)');
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':expertise', $supplierData['expertise']);
            $this->db->bind(':NIC', $supplierData['NIC']);
            $this->db->bind(':id_front_photo', $supplierData['id_front_photo'], PDO::PARAM_LOB);
            $this->db->bind(':id_back_photo', $supplierData['id_back_photo'], PDO::PARAM_LOB);
            $this->db->bind(':bank_details', $supplierData['bank_details']);
            
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Supplier Registration Error: " . $e->getMessage());
            return false;
        }
    }

    public function registerServiceProvider($serviceProviderData) {
        try {
            $this->db->query('INSERT INTO service_providers 
                (provider_id, expertise, description, working_hours, service_areas, 
                 id_number, id_front, id_back, work_photos, bank_details) 
                VALUES 
                (:provider_id, :expertise, :description, :working_hours, :service_areas, 
                 :id_number, :id_front, :id_back, :work_photos, :bank_details)');
    
            $this->db->bind(':provider_id', $serviceProviderData['provider_id']);
            $this->db->bind(':expertise', $serviceProviderData['expertise']);
            $this->db->bind(':description', $serviceProviderData['description']);
            $this->db->bind(':working_hours', $serviceProviderData['working_hours']);
            $this->db->bind(':service_areas', $serviceProviderData['service_areas']);
            $this->db->bind(':id_number', $serviceProviderData['id_number']);
            $this->db->bind(':id_front', $serviceProviderData['id_front'], PDO::PARAM_LOB);
            $this->db->bind(':id_back', $serviceProviderData['id_back'], PDO::PARAM_LOB);
            $this->db->bind(':work_photos', $serviceProviderData['work_photos'], PDO::PARAM_LOB);
            $this->db->bind(':bank_details', $serviceProviderData['bank_details']);
    
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Service Provider Registration Error: " . $e->getMessage());
            return false;
        }
    }
    
   
    


    // Check if email is already registered
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        return $row ? true : false;
    }

    public function isEmailTaken($email)
{
    $this->db->query('SELECT * FROM users WHERE email = :email');
    $this->db->bind(':email', $email);

    $row = $this->db->single();
    return $row ? true : false;
}


    // Login user
    public function login($email, $password) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($row && password_verify($password, $row->password)) {
            return $row;
        } else {
            return false;
        }
    }

    public function getAllUsers() {
        $this->db->query("SELECT users.user_id, users.first_name, users.last_name, users.street, users.district, users.province, 
                           users.email, users.contact_number, users.role
                           FROM users
                           WHERE users.role != 'admin'");
        
        return $this->db->resultSet();
    }

    public function getUserCounts() {
        // Get counts of different user types based on role column
        return [
            'customers' => $this->countUsersByRole('customer'),
            'serviceProviders' => $this->countUsersByRole('service_provider'),
            'suppliers' => $this->countUsersByRole('supplier'),
        ];
    }

    public function getPendingVerifications() {
        // Count service providers that need verification
        $this->db->query("SELECT COUNT(*) as count FROM service_providers WHERE verified = 0");
        $serviceProviderCount = $this->db->single()->count;
        
        return [
            'serviceProviders' => $serviceProviderCount,
        ];
    }

    public function countUsersByRole($role) {
        $this->db->query("SELECT COUNT(*) as count FROM users WHERE role = :role");
        $this->db->bind(':role', $role);
        return $this->db->single()->count;
    }

    public function getUserGrowthData() {
        // Get monthly user registrations for the past 7 months
        $this->db->query("SELECT 
                            MONTH(created_at) as month, 
                            COUNT(*) as count 
                          FROM users 
                          WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 MONTH)
                          GROUP BY MONTH(created_at)
                          ORDER BY month ASC");
        
        $results = $this->db->resultSet();
        
        // Format data for the chart
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
        $data = array_fill(0, 7, 0); // Initialize with zeros
        
        foreach($results as $row) {
            $monthIndex = (intval($row->month) - 1) % 7; // Adjust month to 0-based index
            $data[$monthIndex] = $row->count;
        }
        
        return $data;
    }

    public function deleteUser($id) {
        // Delete user from the users table
        $this->db->query('DELETE FROM users WHERE user_id = :user_id');
        $this->db->bind(':user_id', $id);
        return $this->db->execute();
    }
}
