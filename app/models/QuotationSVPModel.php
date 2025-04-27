<?php
class QuotationSVPModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getAllAppointments()
  {
    $query = "
            SELECT a.appointment_id, a.customer_id, a.service_category, a.appointment_date, a.appointment_time, a.location, a.status
            FROM appointments a
            WHERE a.status = 'Approved'";

    // Execute the query
    $this->db->query($query);

    // Fetch the result set
    return $this->db->resultset();
  }

  

  public function getAllQuotations()
  {
    $query = "
            SELECT a.appointment_id
            FROM quotations a";

    // Execute the query
    $this->db->query($query);

    // Fetch the result set
    return $this->db->resultset();
  }

// public function getAllQuotationslist($service_provider_id)
// {
//     // Updated query to join with appointments table
//     $query = "
//         SELECT 
//             q.quotation_id, 
//             q.appointment_id, 
//             q.service_provider_id, 
//             q.quotation_details, 
//             q.work_hours, 
//             q.cost, 
//             q.status, 
//             q.created_at,
//             a.description as appointment_description,
//             a.location as appointment_location
//         FROM quotations q
//         LEFT JOIN appointments a ON q.appointment_id = a.appointment_id
//         WHERE q.service_provider_id = :service_provider_id
//         ORDER BY q.created_at DESC
//     ";

//     // Prepare and bind
//     $this->db->query($query);
//     $this->db->bind(':service_provider_id', $service_provider_id);

//     // Execute and return results
//     return $this->db->resultSet();
// }

public function getAllQuotationslist($service_provider_id)
{
    $this->db->query('
        SELECT 
            q.quotation_id,
            q.appointment_id,      -- already added earlier
            q.quotation_details,
            q.work_hours,
            q.cost,
            q.status,
            q.created_at,          -- 🛠️ Add this line!
            a.appointment_date,
            a.appointment_time,
            a.location,
            CONCAT(u.first_name, " ", u.last_name) as customer_name
        FROM quotations q
        JOIN appointments a ON q.appointment_id = a.appointment_id
        JOIN users u ON a.customer_id = u.user_id
        WHERE q.service_provider_id = :service_provider_id
        ORDER BY a.appointment_date DESC, a.appointment_time DESC
    ');
    
    $this->db->bind(':service_provider_id', $service_provider_id);
    
    return $this->db->resultSet();
}




  

  public function getAllAppointmentsById($service_provider_id)
{
    $query = "
            SELECT a.appointment_id, a.customer_id, a.service_category, a.appointment_date, a.appointment_time, a.location, a.status
            FROM appointments a
            WHERE a.status = 'Approved' AND a.service_provider_id = :service_provider_id";  // Filter by service_provider_id

    // Prepare the query
    $this->db->query($query);

    // Bind the parameter
    $this->db->bind(':service_provider_id', $service_provider_id);

    // Execute the query
    return $this->db->resultset();
}


  

  public function getAppointmentById($appointment_id)
  {
    $query = "
        SELECT a.appointment_id,a.service_provider_id
        FROM appointments a
        WHERE a.appointment_id = :appointment_id
    ";

    // Prepare the query
    $this->db->query($query);

    // Bind the parameter
    $this->db->bind(':appointment_id', $appointment_id);

    // Fetch the single result
    return $this->db->single();
  }

  public function addQuotation($data)
  {
    $this->db->query(
      "INSERT INTO quotations (appointment_id, service_provider_id, quotation_details, work_hours, cost, status)
          VALUES (:appointment_id, :service_provider_id, :quotation_details, :work_hours, :cost, :status)"
    );

    // Bind parameters
    $this->db->bind(':appointment_id', $data['appointment_id']);
    $this->db->bind(':service_provider_id', $data['service_provider_id']);
    $this->db->bind(':quotation_details', $data['quotation_details']);
    $this->db->bind(':work_hours', $data['work_hours']);
    $this->db->bind(':cost', $data['cost']);
    $this->db->bind(':status', $data['status']);

    // Execute the query
    return $this->db->execute();
  }


  public function getQuotationById($quotation_id)
  {
    $this->db->query('SELECT * FROM quotations WHERE quotation_id = :quotation_id');
    $this->db->bind(':quotation_id', $quotation_id);
    
    $row = $this->db->single();
    return $row;
  }



  public function createQuotation($data)
{
    $this->db->query('
        INSERT INTO quotations (appointment_id, service_provider_id, quotation_details, work_hours, cost, status)
        VALUES (:appointment_id, :service_provider_id, :quotation_details, :work_hours, :cost, "Pending")
    ');

    $this->db->bind(':appointment_id', $data['appointment_id']);
    $this->db->bind(':service_provider_id', $data['service_provider_id']);
    $this->db->bind(':quotation_details', $data['quotation_details']);
    $this->db->bind(':work_hours', $data['work_hours']);
    $this->db->bind(':cost', $data['cost']);

    return $this->db->execute();
}


  public function getQuotationByAppointmentId($appointment_id)
  {
    $this->db->query('SELECT * FROM quotations WHERE appointment_id = :appointment_id');
    $this->db->bind(':appointment_id', $appointment_id);
    return $this->db->single();
  }

}
