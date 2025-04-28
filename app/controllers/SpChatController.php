<?php

class SpChatController extends Controller {
    private $chatModel;
    
    public function __construct() {        
        $this->chatModel = $this->model('ChatModel');
    }
    
    public function index($customer_id = null) {
        if($customer_id) {
            $current_user_id = $_SESSION['user_id'];
            
            $chat_history = $this->chatModel->getChatHistory($current_user_id, $customer_id);
            
            $customer = $this->chatModel->getUserDetails($customer_id);
            
            $data = [
                'chat_history' => $chat_history,
                'other_user' => $customer
            ];
            
            $this->view('chat/sp_chat', $data);
        } else {
            header('Location: ' . URLROOT . '/ServiceProviderController/appointments');
        }
    }
    
    public function sendMessage() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => trim($_POST['receiver_id']),
                'message' => trim($_POST['message']),
                'message_err' => ''
            ];
            
            if(empty($data['message'])) {
                $data['message_err'] = 'Please enter a message';
            }
            
            if(empty($data['message_err'])) {
                if($this->chatModel->sendMessage($data['sender_id'], $data['receiver_id'], $data['message'])) {
                    header('Location: ' . URLROOT . '/SpChatController/index/' . $data['receiver_id']);
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('chat/sp_chat', $data);
            }
        } else {
            header('Location: ' . URLROOT . '/ServiceProviderController/appointments');
        }
    }
} 