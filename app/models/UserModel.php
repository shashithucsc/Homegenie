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
}
