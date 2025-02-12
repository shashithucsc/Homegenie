<?php
class ProfileSVPModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getProfileDetails()
{
    $query = "
      SELECT u.*, sp.*
      FROM users u
      JOIN service_providers sp ON u.user_id = sp.provider_id
      WHERE u.user_id = 2
    ";		
    $this->db->query($query);
    
    $result = $this->db->single();
    
    if (!$result) {
        die("Error: No record found for ID 2");
    }
    
    return $result;
}

  



}
