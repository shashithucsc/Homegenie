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
            redirect('Users/login');
            exit;
        }
        
        $customer = $this->CustomerModel->getCustomer($loggedUserId);
        if (!$customer) {
            die('Customer not found.');
        }
        
        // Get customer appointments
        $appointments = $this->CustomerModel->getCustomerAppointments($loggedUserId);
        
        // Prepare data for the view
        $data = [
            'customer' => $customer,
            'appointments' => $appointments
        ];
        $this->view('Customer/cu_profile', $data);
    }

    public function SPProfile($id = null){
        // Check if ID is provided
        // if($id == null){
        //     redirect('CustomerController/services');
        // }
        
        // Get service provider details
        $serviceProvider = $this->CustomerModel->getServiceProviderById($id);
        
        if(!$serviceProvider){
            die('Service provider not found.');
        }
        
        // Get customer data for the navigation bar
        $loggedUserId = $_SESSION['user_id'] ?? null;
        $customer = null;
        if($loggedUserId){
            $customer = $this->CustomerModel->getCustomer($loggedUserId);
        }
        
        // Prepare data for the view
        $data = [
            'serviceProvider' => $serviceProvider,
            'customer' => $customer
        ];
        
        $this->view('Customer/cu_sp_profile', $data);
    }
    
    // Handle appointment creation
    public function createAppointment(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'sp_id' => $_POST['sp_id'],
                'date' => $_POST['date'],
                'time' => $_POST['time'],
                'address' => $_POST['address'],
                'notes' => $_POST['msg'],
                'cu_id' => $_SESSION['user_id'],
                'created_time' => date('Y-m-d H:i:s')
            ];
            
            if($this->CustomerModel->createAppointment($data)){
                flash('appointment_success', 'Appointment created successfully!');
            } else {
                flash('appointment_error', 'Failed to create appointment', 'alert alert-danger');
            }
            // Redirect back to the service provider's profile
            header('Location: ' . URLROOT . '/CustomerController/SPProfile/' . $data['sp_id']);
        } else {
            header('Location: ' . URLROOT . '/CustomerController/services');
        }
    }
    // Add these new methods to your existing CustomerController class

    public function editAppointment() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'id' => $_POST['id'],
                'date' => $_POST['date'],
                'time' => $_POST['time'],
                'notes' => $_POST['notes'],
                'customer_id' => $_SESSION['user_id']
            ];
            
            // Get appointment to verify ownership
            $appointment = $this->CustomerModel->getAppointmentById($data['id']);
            
            // Verify appointment exists and belongs to current user
            if(!$appointment || $appointment->customer_id != $_SESSION['user_id']) {
                flash('appointment_error', 'Unauthorized access or appointment not found', 'alert alert-danger');
                header('Location: ' . URLROOT . '/CustomerController/profile');
                exit;
            }
            
            if($this->CustomerModel->updateAppointment($data)) {
                flash('appointment_success', 'Appointment updated successfully!');
            } else {
                flash('appointment_error', 'Failed to update appointment', 'alert alert-danger');
            }
            header('Location: ' . URLROOT . '/CustomerController/profile');
        } else {
            header('Location: ' . URLROOT . '/CustomerController/profile');
        }
    }

    public function deleteAppointment($id = null) {
        // Check if ID is provided
        if($id == null) {
            header('Location: ' . URLROOT . '/CustomerController/profile');
            exit;
        }
        
        // Get appointment to verify ownership
        $appointment = $this->CustomerModel->getAppointmentById($id);
        
        // Verify appointment exists and belongs to current user
        if(!$appointment || $appointment->customer_id != $_SESSION['user_id']) {
            flash('appointment_error', 'Unauthorized access or appointment not found', 'alert alert-danger');
            header('Location: ' . URLROOT . '/CustomerController/profile');
            exit;
        }
        
        if($this->CustomerModel->deleteAppointment($id, $_SESSION['user_id'])) {
            flash('appointment_success', 'Appointment deleted successfully!');
        } else {
            flash('appointment_error', 'Failed to delete appointment', 'alert alert-danger');
        }
        header('Location: ' . URLROOT . '/CustomerController/profile');
    }
}

?>