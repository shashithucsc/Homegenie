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

    public function getServiceProviderById($id) {
        $sql = "SELECT u.*, sp.expertise, sp.description, sp.work_photos, sp.working_hours, sp.service_areas 
                FROM users u
                LEFT JOIN service_providers sp ON u.user_id = sp.provider_id
                WHERE u.user_id = :id AND u.role = 'service_provider'";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    public function createAppointment($data) {
        $this->db->query("INSERT INTO appointment (cu_id, sp_id, date, time, cu_address, notes, created_time) 
                         VALUES (:cu_id, :sp_id, :date, :time, :address, :notes, :created_time)");
        
        // Bind values
        $this->db->bind(':cu_id', $data['cu_id']);
        $this->db->bind(':sp_id', $data['sp_id']);
        $this->db->bind(':date', $data['date']);
        $this->db->bind(':time', $data['time']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':notes', $data['notes']);
        $this->db->bind(':created_time', $data['created_time']);
        
        // Execute
        return $this->db->execute();
    }
}
?>