<?php
class SupportSVPModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Get all FAQs
    public function getAllFAQs()
    {
        $this->db->query('SELECT * FROM faq ORDER BY faq_ID ASC');
        return $this->db->resultSet();
    }

    // Create a new issue
    public function createIssue($data)
    {
        $this->db->query('INSERT INTO issues (user_id, description, status) VALUES (:user_id, :description, "pending")');
        
        // Bind values
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':description', $data['description']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get all issues for a specific user
    public function getUserIssues($user_id)
    {
        $this->db->query('SELECT * FROM issues WHERE user_id = :user_id ORDER BY created_at DESC');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    // Get issue by ID
    public function getIssueById($id)
    {
        $this->db->query('SELECT * FROM issues WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}
?> 