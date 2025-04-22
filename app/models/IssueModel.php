<?php
class IssueModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
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