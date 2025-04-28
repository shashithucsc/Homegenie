<?php

class ChatModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Send a message
    public function sendMessage($sender_id, $receiver_id, $message) {
        $this->db->query('INSERT INTO chat (sender_id, receiver_id, message, created_at) VALUES (:sender_id, :receiver_id, :message, NOW())');
        
        // Bind values
        $this->db->bind(':sender_id', $sender_id);
        $this->db->bind(':receiver_id', $receiver_id);
        $this->db->bind(':message', $message);
        
        // Execute
        return $this->db->execute();
    }

    // Get chat history between two users
    public function getChatHistory($user1_id, $user2_id) {
        $this->db->query('SELECT * FROM chat 
                         WHERE (sender_id = :user1_id AND receiver_id = :user2_id) 
                         OR (sender_id = :user2_id AND receiver_id = :user1_id) 
                         ORDER BY created_at ASC');
        
        // Bind values
        $this->db->bind(':user1_id', $user1_id);
        $this->db->bind(':user2_id', $user2_id);
        
        // Execute
        $this->db->execute();
        
        return $this->db->resultSet();
    }

    // Get user details for chat
    public function getUserDetails($user_id) {
        $this->db->query('SELECT user_id, first_name, last_name, profile_image FROM users WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $this->db->execute();
        
        return $this->db->single();
    }
} 