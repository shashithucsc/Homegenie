<?php
class ProfileSVPModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getProfileDetails($service_provider_id)
    {
        $this->db->query('
        SELECT 
            u.user_id,
            CONCAT(u.first_name, " ", u.last_name) as name,
            u.email,
            u.contact_number as phone,
            u.address
        FROM users u
        WHERE u.user_id = :service_provider_id
    ');
        $this->db->bind(':service_provider_id', $service_provider_id);

        $row = $this->db->single();
        return $row ? $row : null;
    }


    public function updateProfileFields($data)
    {
        $query = "
        UPDATE service_providers
        SET expertise = :expertise,
            service_areas = :service_areas,
            working_hours = :working_hours
        WHERE provider_id = :service_provider_id
    ";

        $this->db->query($query);
        $this->db->bind(':expertise', $data['expertise']);
        $this->db->bind(':service_areas', $data['service_areas']);
        $this->db->bind(':working_hours', $data['working_hours']);
        $this->db->bind(':service_provider_id', $data['service_provider_id']);

        return $this->db->execute();
    }




    public function getUserDetails($user_id)
    {
        $this->db->query('
        SELECT 
            user_id,
            first_name,
            last_name,
            email,
            contact_number,
            street,
            district,
            province,
            profile_image
        FROM users 
        WHERE user_id = :user_id
    ');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    public function getProviderDetails($provider_id)
    {
        $this->db->query('
        SELECT 
            provider_id,
            expertise,
            description,
            working_hours,
            service_areas,
            id_number,
            hourly_rate
        FROM service_providers 
        WHERE provider_id = :provider_id
    ');
        $this->db->bind(':provider_id', $provider_id);
        return $this->db->single();
    }

    public function getAverageRating($service_provider_id)
    {
        $this->db->query('
        SELECT AVG(rating) as average_rating 
        FROM appointments 
        WHERE service_provider_id = :service_provider_id 
        AND finish_status = "complete" 
        AND rating IS NOT NULL
    ');
        $this->db->bind(':service_provider_id', $service_provider_id);
        $result = $this->db->single();
        return $result ? round($result->average_rating, 1) : 0;
    }

    public function getQuotationStats($service_provider_id)
    {
        $this->db->query('
        SELECT 
            SUM(CASE WHEN status = "Approved" THEN 1 ELSE 0 END) as approved_count,
            SUM(CASE WHEN status = "Pending" THEN 1 ELSE 0 END) as pending_count,
            SUM(CASE WHEN status = "Rejected" THEN 1 ELSE 0 END) as rejected_count
        FROM quotations 
        WHERE service_provider_id = :service_provider_id
    ');
        $this->db->bind(':service_provider_id', $service_provider_id);
        return $this->db->single();
    }

    public function getJobStats($service_provider_id)
    {
        $this->db->query('
        SELECT 
            SUM(CASE WHEN finish_status = "complete" THEN 1 ELSE 0 END) as completed_jobs,
            SUM(CASE WHEN finish_status = "pending" THEN 1 ELSE 0 END) as pending_jobs
        FROM appointments 
        WHERE service_provider_id = :service_provider_id
    ');
        $this->db->bind(':service_provider_id', $service_provider_id);
        return $this->db->single();
    }
    public function updateProfessionalInfo($provider_id, $expertise, $working_hours, $service_areas, $description, $hourly_rate)
    {
        $this->db->query('
        UPDATE service_providers 
        SET 
            expertise = :expertise,
            working_hours = :working_hours,
            service_areas = :service_areas,
            description = :description,
            hourly_rate = :hourly_rate
        WHERE provider_id = :provider_id
    ');

        $this->db->bind(':expertise', $expertise);
        $this->db->bind(':working_hours', $working_hours);
        $this->db->bind(':service_areas', $service_areas);
        $this->db->bind(':description', $description);
        $this->db->bind(':hourly_rate', $hourly_rate);
        $this->db->bind(':provider_id', $provider_id);

        return $this->db->execute();
    }


}
