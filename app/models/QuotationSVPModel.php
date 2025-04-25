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

public function getAllQuotationslist($service_provider_id)
{
    // Updated query with WHERE clause and parameter placeholder
    $query = "
        SELECT q.quotation_id, q.appointment_id, q.service_provider_id, q.quotation_details, q.price, q.status, q.created_at, q.updated_at
        FROM quotations q
        WHERE q.service_provider_id = :service_provider_id
    ";

    // Prepare and bind
    $this->db->query($query);
    $this->db->bind(':service_provider_id', $service_provider_id);

    // Execute and return results
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
      "INSERT INTO quotations (appointment_id, service_provider_id, quotation_details, price, status)
          VALUES (:appointment_id, :service_provider_id, :quotation_details, :price, :status)"
    );

    // Bind parameters
    $this->db->bind(':appointment_id', $data['appointment_id']);
    $this->db->bind(':service_provider_id', $data['service_provider_id']);
    $this->db->bind(':quotation_details', $data['quotation_details']);
    $this->db->bind(':price', $data['price']);
    $this->db->bind(':status', $data['status']);

    // Execute the query
    return $this->db->execute();
  }

  public function updateQuotation($id, $details, $price)
  {
    $this->db->query("UPDATE quotations SET quotation_details = :details, price = :price WHERE quotation_id = :id");
    $this->db->bind(':details', $details);
    $this->db->bind(':price', $price);
    $this->db->bind(':id', $id);

    return $this->db->execute();
  }


  public function deleteQuotation($quotation_id)
  {
    $this->db->query("DELETE FROM quotations WHERE quotation_id = :quotation_id");
    $this->db->bind(':quotation_id', $quotation_id);
    return $this->db->execute();
  }

  public function getQuotationById($quotation_id)
  {
    $this->db->query('SELECT * FROM quotations WHERE quotation_id = :quotation_id');
    $this->db->bind(':quotation_id', $quotation_id);
    
    $row = $this->db->single();
    return $row;
  }

}
