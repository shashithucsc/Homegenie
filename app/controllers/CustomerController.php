<?php

class CustomerController extends Controller {

    private $CustomerModel;
    public function __construct(){
        $this->CustomerModel = $this->model('CustomerModel');
    }

    public function index(){
        $this->view('Customer/home');
    }

    public function services(){
        $serviceProviders = $this->CustomerModel->getServiceProviders();
        if (!$serviceProviders) {
            die('No service providers found.');
        }
        $data = [
            'serviceProviders' => $serviceProviders
        ];
        $this->view('Customer/services', $data);
    }

    public function about(){
        $this->view('Customer/about');
    }

    public function contact(){
        $this->view('Customer/contact');
    }

    public function profile(){
        $loggedUserId = $_SESSION['user_id'] ?? null;

        if (!$loggedUserId) {
            // Handle unauthorized access or redirect to login
            header('Location: /login');
            exit;
        }
        $customer = $this->CustomerModel->getCustomer($loggedUserId);
        if (!$customer) {
            die('Customer not found.');
        }
    
        // Prepare data for the view
        $data = [
            'customer' => $customer,
        ];
        $this->view('Customer/cu_profile', $data);
    }
   
}

?>