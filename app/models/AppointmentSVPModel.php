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
        $this->db->query('SELECT * FROM appointments WHERE service_provider_id = :service_provider_id AND status = "Approved" ORDER BY appointment_date DESC, appointment_time DESC');
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
}
?>
