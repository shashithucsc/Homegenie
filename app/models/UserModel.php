<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Register a new user based on role
    public function register($data) {
        $this->db->query('INSERT INTO users (first_name, last_name, contact_number, email, address, profile_image, password, role, agree_terms) VALUES (:first_name, :last_name, :contact_number, :email, :address, :profile_image, :password, :role, :agree_terms)');

        // Bind common user data
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':contact_number', $data['contact_number']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':profile_image', $data['profile_image']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':role', $data['role']);
        $this->db->bind(':agree_terms', $data['agree_terms']);

        if ($this->db->execute()) {
            $userId = $this->db->lastInsertId();

            // Role-specific data
            switch ($data['role']) {
                case 'supplier':
                    $this->registerSupplier($userId, $data);
                    break;
                case 'service_provider':
                    $this->registerServiceProvider($userId, $data);
                    break;
                case 'customer':
                    $this->registerCustomer($userId);
                    break;
            }
            return true;
        } else {
            return false;
        }
    }

    // Register supplier-specific data
    private function registerSupplier($userId, $data) {
        $this->db->query('INSERT INTO suppliers (supplier_id, expertise, description, service_areas) VALUES (:supplier_id, :expertise, :description, :service_areas)');
        $this->db->bind(':supplier_id', $userId);
        $this->db->bind(':expertise', $data['expertise']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':service_areas', $data['service_areas']);
        $this->db->execute();
    }

    // Register service provider-specific data
    private function registerServiceProvider($userId, $data) {
        $this->db->query('INSERT INTO service_providers (provider_id, expertise, description, work_photos, working_hours, service_areas, id_number, id_front, id_back) VALUES (:provider_id, :expertise, :description, :work_photos, :working_hours, :service_areas, :id_number, :id_front, :id_back)');
        $this->db->bind(':provider_id', $userId);
        $this->db->bind(':expertise', $data['expertise']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':work_photos', $data['work_photos']);
        $this->db->bind(':working_hours', $data['working_hours']);
        $this->db->bind(':service_areas', $data['service_areas']);
        $this->db->bind(':id_number', $data['id_number']);
        $this->db->bind(':id_front', $data['id_front']);
        $this->db->bind(':id_back', $data['id_back']);
        $this->db->execute();
    }

    // Register customer-specific data
    private function registerCustomer($userId) {
        $this->db->query('INSERT INTO customers (customer_id) VALUES (:customer_id)');
        $this->db->bind(':customer_id', $userId);
        $this->db->execute();
    }

    // Check if email is already registered
    public function findUserByEmail($email) {
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
        $this->db->query("SELECT users.user_id, users.first_name, users.last_name, users.address, 
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

    private function countUsersByRole($role) {
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

    public function deleteUser($userId) {
        $this->db->query("DELETE FROM users WHERE user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }
    
    public function searchUsers($searchTerm) {
        $this->db->query("SELECT users.user_id, users.first_name, users.last_name, users.address, 
                          users.email, users.contact_number, users.role
                          FROM users
                          WHERE users.role != 'admin' AND 
                          (users.first_name LIKE :search OR 
                           users.last_name LIKE :search OR 
                           users.email LIKE :search OR 
                           users.contact_number LIKE :search)");
        
        $this->db->bind(':search', '%' . $searchTerm . '%');
        return $this->db->resultSet();
    }
}
