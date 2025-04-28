<?php

class CustomerModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getServiceProviders() {
        $sql = "SELECT u.*,
                sp.*
                FROM users u
                JOIN service_providers sp ON u.user_id = sp.provider_id
                WHERE u.role = 'service_provider'";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getCustomer($id) {
        $sql = "SELECT u.*
                FROM users u
                WHERE u.user_id = :user_id";
        $this->db->query($sql);
        $this->db->bind(':user_id', $id);
        return $this->db->single();
    }

    public function getServiceProviderById($id) {
        $sql = "SELECT u.*, 
                sp.*
                FROM users u
                LEFT JOIN service_providers sp ON u.user_id = sp.provider_id
                WHERE u.user_id = :id AND u.role = 'service_provider'";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    public function createAppointment($data) {
        $this->db->query("INSERT INTO appointments (customer_id, service_provider_id, appointment_date, appointment_time, location, description, created_at) 
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

    public function getPendingAppointments($userId) {
        $sql = "SELECT 
                a.*,
                u.first_name AS sp_first_name, 
                u.last_name AS sp_last_name
                FROM appointments a
                JOIN users u ON a.service_provider_id = u.user_id
                WHERE a.customer_id = :user_id AND a.status = 'pending'
                ORDER BY a.created_at DESC";
        
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    public function getApprovedAppointments($userId) {
        $sql = "SELECT 
                a.*,
                u.first_name AS sp_first_name, 
                u.last_name AS sp_last_name,
                q.quotation_details,
                q.work_hours,
                q.cost
                FROM appointments a
                JOIN users u ON a.service_provider_id = u.user_id
                LEFT JOIN quotations q ON a.appointment_id = q.appointment_id
                WHERE a.customer_id = :user_id AND a.status = 'approved' AND q.status = 'Pending'
                ORDER BY a.created_at DESC";
        
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    public function getPaidAppointments($userId) {
        $sql = "SELECT 
                a.*,
                u.first_name AS sp_first_name, 
                u.last_name AS sp_last_name,
                q.quotation_details,
                q.work_hours,
                q.cost
                FROM appointments a
                JOIN users u ON a.service_provider_id = u.user_id
                JOIN quotations q ON a.appointment_id = q.appointment_id
                WHERE a.customer_id = :user_id AND a.status = 'Approved' AND q.status = 'Approved' AND a.finish_status != 'complete'
                ORDER BY a.created_at DESC";
        
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    public function getFinishedAppointments($userId) {
        $sql = "SELECT 
                a.*,
                u.first_name AS sp_first_name, 
                u.last_name AS sp_last_name,
                q.quotation_details,
                q.work_hours,
                q.cost
                FROM appointments a
                JOIN users u ON a.service_provider_id = u.user_id
                JOIN quotations q ON a.appointment_id = q.appointment_id
                WHERE a.customer_id = :user_id AND q.status = 'Approved' AND a.finish_status = 'complete'
                ORDER BY a.created_at DESC";
        
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
    // Add these new methods to your existing CustomerModel class

public function updateAppointment($data) {
    $this->db->query("UPDATE appointments SET 
                      appointment_date = :date,
                      appointment_time = :time,
                      description = :notes,
                      updated_at = NOW()
                      WHERE appointment_id = :id AND customer_id = :customer_id");
    
    // Bind values
    $this->db->bind(':date', $data['date']);
    $this->db->bind(':time', $data['time']);
    $this->db->bind(':notes', $data['notes']);
    $this->db->bind(':id', $data['id']);
    $this->db->bind(':customer_id', $data['customer_id']);
    
    // Execute
    return $this->db->execute();
}

public function deleteAppointment($id, $customerId) {
    $this->db->query("DELETE FROM appointments WHERE appointment_id = :id AND customer_id = :customer_id");
    
    // Bind values
    $this->db->bind(':id', $id);
    $this->db->bind(':customer_id', $customerId);
    
    // Execute
    return $this->db->execute();
}

public function getAppointmentById($id) {
    $this->db->query("SELECT * FROM appointments WHERE appointment_id = :id");
    $this->db->bind(':id', $id);
    return $this->db->single();
}

public function getQuotationByAppointmentId($appointment_id) {
    $this->db->query("SELECT * FROM quotations WHERE appointment_id = :appointment_id");
    $this->db->bind(':appointment_id', $appointment_id);
    return $this->db->single();
}

public function updateAppointmentStatus($appointment_id, $status) {
    $this->db->query("UPDATE appointments SET status = :status, updated_at = NOW() WHERE appointment_id = :appointment_id");
    $this->db->bind(':status', $status);
    $this->db->bind(':appointment_id', $appointment_id);
    return $this->db->execute();
}

public function updateAppointmentWithRating($appointment_id, $rating, $comment) {
    $this->db->query("UPDATE appointments SET finish_status = 'complete', rating = :rating, comment = :comment, updated_at = NOW() WHERE appointment_id = :appointment_id");
    $this->db->bind(':rating', $rating);
    $this->db->bind(':comment', $comment);
    $this->db->bind(':appointment_id', $appointment_id);
    return $this->db->execute();
}
public function updateQuotationStatus($appointment_id, $status) {
    $this->db->query("UPDATE quotations SET status = :status WHERE appointment_id = :appointment_id");
    $this->db->bind(':status', $status);
    $this->db->bind(':appointment_id', $appointment_id);
    return $this->db->execute();
}

public function createTransaction($appointment_id, $amount) {
    $this->db->query("INSERT INTO transactions (appointment_id, amount) 
                     VALUES (:appointment_id, :amount)");
    
    $this->db->bind(':appointment_id', $appointment_id);
    $this->db->bind(':amount', $amount);
    
    return $this->db->execute();
}

public function updateProfile($data) {
    $this->db->query("UPDATE users SET 
        first_name = :fname,
        last_name = :lname,
        contact_number = :contact_number,
        email = :email,
        profile_image = :profile_image,
        street = :street,
        district = :district,
        province = :province
        WHERE user_id = :user_id");

    // Bind values
    $this->db->bind(':fname', $data['fname']);
    $this->db->bind(':lname', $data['lname']);
    $this->db->bind(':contact_number', $data['contact_number']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':profile_image', $data['profile_image']);
    $this->db->bind(':street', $data['street']);
    $this->db->bind(':district', $data['district']);
    $this->db->bind(':province', $data['province']);
    $this->db->bind(':user_id', $data['user_id']);

    // Execute
    return $this->db->execute();
}
}
?>