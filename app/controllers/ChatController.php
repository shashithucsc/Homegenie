<?php

class ChatController extends Controller {
    private $chatModel;
    
    public function __construct() {
        // Check if user is logged in
        
        $this->chatModel = $this->model('ChatModel');
    }
    
    // Display chat interface
    public function index($other_user_id = null) {
        if($other_user_id) {
            $current_user_id = $_SESSION['user_id'];
            
            // Get chat history
            $chat_history = $this->chatModel->getChatHistory($current_user_id, $other_user_id);
            
            // Get other user details
            $other_user = $this->chatModel->getUserDetails($other_user_id);
            
            $data = [
                'chat_history' => $chat_history,
                'other_user' => $other_user
            ];
            
            $this->view('chat/index', $data);
        } else {
            header( 'Location: ' . URLROOT . '/CustomerController/cu_appointment');
        }
    }
    
    // Send a message
    public function sendMessage() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => trim($_POST['receiver_id']),
                'message' => trim($_POST['message']),
                'message_err' => ''
            ];
            
            // Validate message
            if(empty($data['message'])) {
                $data['message_err'] = 'Please enter a message';
            }
            
            // Make sure there are no errors
            if(empty($data['message_err'])) {
                // Send message
                if($this->chatModel->sendMessage($data['sender_id'], $data['receiver_id'], $data['message'])) {
                    // Redirect back to chat
                    header('Location: ' . URLROOT . '/ChatController/index/' . $data['receiver_id']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('chat/index', $data);
            }
        } else {
            header('Location: ' . URLROOT . '/CustomerController/cu_appointment');
        }
    }
} 