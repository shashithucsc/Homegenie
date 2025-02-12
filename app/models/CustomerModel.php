<?php

class CustomerModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getServiceProviders() {
        $this->db->query("SELECT * FROM users WHERE role = 'service_provider'");
        return $this->db->resultSet();
    }

    public function getCustomer($id) {
        $sql = "SELECT u.user_id, u.first_name, u.last_name, u.contact_number, u.email, u.address, u.profile_image
            FROM users u
            LEFT JOIN customers c ON u.user_id = c.customer_id
            WHERE u.user_id = :user_id";
        $this->db->query($sql);
        $this->db->bind(':user_id', $id);
        return $this->db->single();
    }
}
?>