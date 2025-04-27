<?php

class AppointmentSVPModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Fetch all pending appointments for the logged-in service provider
    public function getPendingAppointments($service_provider_id)
    {
        $this->db->query('SELECT * FROM appointments WHERE service_provider_id = :service_provider_id AND status = "Pending" ORDER BY appointment_date DESC');
        $this->db->bind(':service_provider_id', $service_provider_id);
        return $this->db->resultSet();
    }

    // Fetch all approved appointments for the logged-in service provider
    public function getApprovedAppointments($service_provider_id)
    {
        $this->db->query('
            SELECT 
                a.appointment_id,
                a.customer_id,
                a.description,
                a.appointment_date,
                a.appointment_time,
                a.location,
                CONCAT(u.first_name, " ", u.last_name) as customer_name,
                u.contact_number,
                q.quotation_details,
                q.work_hours,
                q.cost
            FROM appointments a
            JOIN quotations q ON a.appointment_id = q.appointment_id
            JOIN users u ON a.customer_id = u.user_id
            WHERE q.service_provider_id = :service_provider_id 
            AND q.status = "Approved"
            ORDER BY a.appointment_date DESC, a.appointment_time DESC
        ');
        $this->db->bind(':service_provider_id', $service_provider_id);
        return $this->db->resultSet();
    }
    
    

    // Function to approve an appointment
    public function approveAppointment($appointmentId) {
        $query = "UPDATE appointments SET status = 'Approved', updated_at = NOW() WHERE appointment_id = :appointment_id";
        $this->db->query($query);
        $this->db->bind(':appointment_id', $appointmentId);
        
        return $this->db->execute();
    }
    

    // Function to cancel an appointment
    public function cancelAppointment($appointmentId) {
        $query = "UPDATE appointments SET status = 'Cancelled' WHERE appointment_id = :appointment_id";
        $this->db->query($query);
        $this->db->bind(':appointment_id', $appointmentId);
        
        if ($this->db->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }

    public function getAppointmentById($appointment_id)
    {
        $this->db->query('SELECT * FROM appointments WHERE appointment_id = :appointment_id');
        $this->db->bind(':appointment_id', $appointment_id);
        
        $row = $this->db->single();
        return $row;
    }

    public function rejectAppointment($appointmentId) {
        $query = "UPDATE appointments SET status = 'rejected', updated_at = NOW() WHERE appointment_id = :appointment_id";
        $this->db->query($query);
        $this->db->bind(':appointment_id', $appointmentId);
        
        return $this->db->execute();
    }

    public function getHourlyRate($service_provider_id)
{
    $this->db->query('SELECT hourly_rate FROM service_providers WHERE provider_id = :provider_id');
    $this->db->bind(':provider_id', $service_provider_id);
    return $this->db->single()->hourly_rate;
}






}
?>
