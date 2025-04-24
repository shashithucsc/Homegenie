<?php
class FAQModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database;
    }
    
    // Get all FAQs
    public function getAllFAQs() {
        $this->db->query("SELECT * FROM faq ORDER BY faq_ID DESC");
        return $this->db->resultSet();
    }
    
    // Add a new FAQ
    public function addFAQ($data) {
        $this->db->query("INSERT INTO faq (topic, content) VALUES (:topic, :content)");
        $this->db->bind(':topic', $data['topic']);
        $this->db->bind(':content', $data['content']);
        return $this->db->execute();
    }
    
    // Get a single FAQ by ID
    public function getFAQById($id) {
        $this->db->query("SELECT * FROM faq WHERE faq_ID = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Update a FAQ
    public function updateFAQ($data) {
        $this->db->query("UPDATE faq SET topic = :topic, content = :content WHERE faq_ID = :id");
        $this->db->bind(':topic', $data['topic']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':id', $data['id']);
        return $this->db->execute();
    }
    
    // Delete a FAQ
    public function deleteFAQ($id) {
        $this->db->query("DELETE FROM faq WHERE faq_ID = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}