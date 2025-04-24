<?php
class IssueModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }

    public function getIssues() {
        $this->db->query("SELECT issues.*, users.first_name, users.last_name, users.contact_number, users.email 
                         FROM issues 
                         JOIN users ON issues.user_id = users.user_id");
        return $this->db->resultSet();
    }

    public function getIssueById($id) {
        $this->db->query("SELECT issues.*, users.first_name, users.last_name, users.contact_number, users.email 
                         FROM issues 
                         JOIN users ON issues.user_id = users.user_id
                         WHERE issues.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function markIssueComplete($id) {
        $this->db->query("UPDATE issues SET status = 'completed' WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    public function getPendingIssuesCount() {
        // Count issues with pending status
        $this->db->query("SELECT COUNT(*) as count FROM issues WHERE status = 'pending'");
        return $this->db->single()->count;
    }
    
    public function getAllIssuesCount() {
        $this->db->query("SELECT COUNT(*) as count FROM issues");
        return $this->db->single()->count;
    }
    
    public function getIssuesByStatus() {
        $this->db->query("SELECT status, COUNT(*) as count FROM issues GROUP BY status");
        return $this->db->resultSet();
    }
}