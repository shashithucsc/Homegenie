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
    return $row;
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

public function getAverageRating($svp_id) {
    $sql = "SELECT AVG(rating) as average_rating 
            FROM appointments 
            WHERE svp_id = :svp_id 
            AND finish_status = 'complete' 
            AND rating IS NOT NULL";
    
    $this->db->query($sql);
    $this->db->bind(':svp_id', $svp_id);
    $result = $this->db->single();
    
    return $result ? round($result->average_rating, 1) : 0;
}

}
