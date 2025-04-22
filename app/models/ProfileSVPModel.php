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
      $query = "
          SELECT u.*, sp.*
          FROM users u
          JOIN service_providers sp ON u.user_id = sp.provider_id
          WHERE u.user_id = :service_provider_id
      ";		
      
      $this->db->query($query);
      $this->db->bind(':service_provider_id', $service_provider_id); 
      
      $result = $this->db->single();
  
      if (!$result) {
          die("Error: No record found for ID $service_provider_id");
      }
  
      return $result;
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




}
