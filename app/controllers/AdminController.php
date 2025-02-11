<?php
Class AdminController extends Controller{
    public function index(){
        $loggedUserId = $_SESSION['user_id'] ?? null;

        if (!$loggedUserId) {
            // Handle unauthorized access or redirect to login
            header('Location: /login');
            exit;
        }
        $this->view('Admin/AdminDashBoard');
    }

    public function manageUsers(){
        $this->view('Admin/ManageUsers');   
    } 

    public function verifyUsers(){
        $this->view('Admin/verifyUsers');   
    }

    public function viewIsuues(){
        $this->view('Admin/ViewIssues');   
    } 

    public function viewOrders(){
        $this->view('Admin/viewOrders');   
    } 
    
    public function faq(){
        $this->view('Admin/FAQ');   
    } 
    

}
?>