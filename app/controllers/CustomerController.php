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

    public function appointment(){
        $loggedUserId = $_SESSION['user_id'] ?? null;

        // Get customer appointments
        $p_appointments = $this->CustomerModel->getPendingAppointments($loggedUserId);
        $a_appointments = $this->CustomerModel->getApprovedAppointments($loggedUserId);
        if (!$p_appointments || !$a_appointments) {
            die('No appointments found.');
        }
        $data = [
            'p_appointments' => $p_appointments,
            'a_appointments' => $a_appointments
        ];

        $this->view('Customer/cu_appointment', $data);
    }

    public function contact(){
        $this->view('Customer/contact');
    }

    public function profile(){
        $loggedUserId = $_SESSION['user_id'] ?? null;
    
        if (!$loggedUserId) {
            // Handle unauthorized access or redirect to login
            header('Location: ' . URLROOT . '/LoginController');
            exit;
        }
        $appointments = $this->CustomerModel->getPendingAppointments($loggedUserId);
        $customer = $this->CustomerModel->getCustomer($loggedUserId);
        if (!$customer) {
            die('Customer not found.');
        }
        
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
                header('Location: ' . URLROOT . '/CustomerController/appointment');
                exit;
            }
            
            if($this->CustomerModel->updateAppointment($data)) {
                flash('appointment_success', 'Appointment updated successfully!');
            } else {
                flash('appointment_error', 'Failed to update appointment', 'alert alert-danger');
            }
            header('Location: ' . URLROOT . '/CustomerController/appointment');
        } else {
            header('Location: ' . URLROOT . '/CustomerController/appointment');
        }
    }

    public function deleteAppointment($id = null) {
        // Check if ID is provided
        if($id == null) {
            header('Location: ' . URLROOT . '/CustomerController/appointment');
            exit;
        }
        
        // Get appointment to verify ownership
        $appointment = $this->CustomerModel->getAppointmentById($id);
        
        // Verify appointment exists and belongs to current user
        if(!$appointment || $appointment->customer_id != $_SESSION['user_id']) {
            flash('appointment_error', 'Unauthorized access or appointment not found', 'alert alert-danger');
            header('Location: ' . URLROOT . '/CustomerController/appointment');
            exit;
        }
        
        if($this->CustomerModel->deleteAppointment($id, $_SESSION['user_id'])) {
            flash('appointment_success', 'Appointment deleted successfully!');
        } else {
            flash('appointment_error', 'Failed to delete appointment', 'alert alert-danger');
        }
        header('Location: ' . URLROOT . '/CustomerController/appointment');
    }

    public function payment($appointment_id) {
        // Get appointment details
        $appointment = $this->CustomerModel->getAppointmentById($appointment_id);
        
        if(!$appointment || $appointment->customer_id != $_SESSION['user_id']) {
            flash('payment_error', 'Unauthorized access or appointment not found', 'alert alert-danger');
            header('Location: ' . URLROOT . '/CustomerController/appointment');
            exit;
        }

        // Get quotation details
        $quotation = $this->CustomerModel->getQuotationByAppointmentId($appointment_id);
        
        if(!$quotation) {
            flash('payment_error', 'No quotation found for this appointment', 'alert alert-danger');
            header('Location: ' . URLROOT . '/CustomerController/appointment');
            exit;
        }

        $data = [
            'appointment' => $appointment,
            'quotation' => $quotation
        ];

        $this->view('Customer/payment', $data);
    }

    public function processPayment() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'appointment_id' => $_POST['appointment_id'],
                'amount' => $_POST['amount']
            ];

            // Create transaction record
            if($this->CustomerModel->createTransaction($data['appointment_id'], $data['amount'])) {
                // Update appointment status to completed
                if($this->CustomerModel->updateAppointmentStatus($data['appointment_id'], 'completed')) {
                    flash('payment_success', 'Payment processed successfully!');
                    header('Location: ' . URLROOT . '/CustomerController/appointment');
                    exit;
                }
            }
            
            flash('payment_error', 'Failed to process payment', 'alert alert-danger');
            header('Location: ' . URLROOT . '/CustomerController/payment/' . $data['appointment_id']);
            exit;
        } else {
            header('Location: ' . URLROOT . '/CustomerController/appointment');
            exit;
        }
    }
}

?>