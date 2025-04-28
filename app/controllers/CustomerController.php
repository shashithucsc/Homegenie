<?php

class CustomerController extends Controller {

    private $CustomerModel;
    private $ContactModel;
    public function __construct(){
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
            header('Location: ' . URLROOT . '/LoginController');
            exit;
        }
        $this->CustomerModel = $this->model('CustomerModel');
        $this->ContactModel = $this->model('ContactModel');
    }

    public function index(){
        $this->view('Customer/home');
    }

    public function services(){
        $serviceProviders = $this->CustomerModel->getServiceProviders();
        // if (!$serviceProviders) {
        //     die('No service providers found.');
        // }
        $data = [
            'serviceProviders' => $serviceProviders
        ];
        $this->view('Customer/cu_services', $data);
    }

    public function about(){
        $this->view('Customer/cu_about');
    }

    public function appointment(){
        $loggedUserId = $_SESSION['user_id'] ?? null;

        // Get customer appointments
        $p_appointments = $this->CustomerModel->getPendingAppointments($loggedUserId);
        $a_appointments = $this->CustomerModel->getApprovedAppointments($loggedUserId);
        
        $data = [
            'p_appointments' => $p_appointments,
            'a_appointments' => $a_appointments
        ];

        $this->view('Customer/cu_appointment', $data);
    }

    public function contact(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'subject' => trim($_POST['subject']),
                'message' => trim($_POST['message'])
            ];
            
            // Validate data
            if (empty($data['full_name']) || empty($data['email']) || empty($data['subject']) || empty($data['message'])) {
                die('Please fill in all required fields.');
            }
            
            // Send message to the database
            if ($this->ContactModel->createContact($data)) {
                flash('contact_success', 'Your message has been sent successfully!');
                header('Location: ' . URLROOT . '/HomeController/contact');
            } else {
                die('Something went wrong. Please try again later.');
            }
        }
        $this->view('Customer/contact');
    }

    public function profile(){
        $loggedUserId = $_SESSION['user_id'] ?? null;
    
        if (!$loggedUserId) {
            // Handle unauthorized access or redirect to login
            header('Location: ' . URLROOT . '/LoginController');
            exit;
        }
        $p_appointments = $this->CustomerModel->getPaidAppointments($loggedUserId);
        $f_appointments = $this->CustomerModel->getFinishedAppointments($loggedUserId);
        $customer = $this->CustomerModel->getCustomer($loggedUserId);
        if (!$customer) {
            die('Customer not found.');
        }
        
        // Prepare data for the view
        $data = [
            'customer' => $customer,
            'p_appointments' => $p_appointments,
            'f_appointments' => $f_appointments
        ];
        $this->view('Customer/cu_profile', $data);
    }
    public function editProfile() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'id' => $_POST['id'],
                'fname' => $_POST['fname'],
                'lname' => $_POST['lname'],
                'province' => $_POST['province'],
                'district' => $_POST['district'],
                'street' => $_POST['street'],
                'psw' => $_POST['psw'],
                'rpsw' => $_POST['rpsw'],
                'customer_id' => $_SESSION['user_id']
            ];
            
            // Get appointment to verify ownership
            $editprofile = $this->CustomerModel->getProfileById($data['id']);
            
            // Verify appointment exists and belongs to current user
            if(!$editprofile || $editprofile->customer_id != $_SESSION['user_id']) {
                flash('profile_update_error', 'Unauthorized access or profile not found', 'alert alert-danger');
                header('Location: ' . URLROOT . '/CustomerController/profile');
                exit;
            }
            
            if($this->CustomerModel->updateProfile($data)) {
                flash('profile_update_success', 'Profile updated successfully!');
            } else {
                flash('profile_update_error', 'Failed to update profile', 'alert alert-danger');
            }
            header('Location: ' . URLROOT . '/CustomerController/profile');
        } else {
            header('Location: ' . URLROOT . '/CustomerController/profile');
        }
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

    public function rateAppointment($appointment_id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
            $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
            
            // Validate rating (1-5)
            if($rating < 1 || $rating > 5) {
                flash('appointment_error', 'Invalid rating. Please provide a rating between 1 and 5.', 'alert alert-danger');
                header('Location: ' . URLROOT . '/CustomerController/profile');
                exit;
            }
            
            if($this->CustomerModel->updateAppointmentWithRating($appointment_id, $rating, $comment)) {
                flash('appointment_success', 'Appointment rated successfully!');
            } else {
                flash('appointment_error', 'Failed to rate appointment', 'alert alert-danger');
            }
            header('Location: ' . URLROOT . '/CustomerController/profile');
        } else {
            header('Location: ' . URLROOT . '/CustomerController/profile');
        }
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
                if($this->CustomerModel->updateQuotationStatus($data['appointment_id'], 'Approved')) {
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
    

    public function updateProfile() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'fname' => trim($_POST['fname']),
                'lname' => trim($_POST['lname']),
                'contact_number' => trim($_POST['contact_number']),
                'email' => trim($_POST['email']),
                'street' => trim($_POST['street']),
                'district' => trim($_POST['district']),
                'profile_image' => null, // Initialize as null
                'user_id' => $_SESSION['user_id']
            ];
            
            // Automatically set province based on district
            $district = $data['district'];
            $province = '';
            
            // Western Province
            if (in_array($district, ['Colombo', 'Gampaha', 'Kalutara'])) {
                $province = 'Western Province';
            }
            // Central Province
            else if (in_array($district, ['Kandy', 'Matale', 'Nuwara Eliya'])) {
                $province = 'Central Province';
            }
            // Southern Province
            else if (in_array($district, ['Galle', 'Matara', 'Hambantota'])) {
                $province = 'Southern Province';
            }
            // Eastern Province
            else if (in_array($district, ['Ampara', 'Batticaloa', 'Trincomalee'])) {
                $province = 'Eastern Province';
            }
            // Northern Province
            else if (in_array($district, ['Jaffna', 'Kilinochchi', 'Mullaitivu', 'Vavuniya', 'Mannar'])) {
                $province = 'Northern Province';
            }
            // North Western Province
            else if (in_array($district, ['Kurunegala', 'Puttalam'])) {
                $province = 'North Western Province';
            }
            // North Central Province
            else if (in_array($district, ['Anuradhapura', 'Polonnaruwa'])) {
                $province = 'North Central Province';
            }
            // Sabaragamuwa Province
            else if (in_array($district, ['Kegalle', 'Ratnapura'])) {
                $province = 'Sabaragamuwa Province';
            }
            // Uva Province
            else if (in_array($district, ['Badulla', 'Monaragala'])) {
                $province = 'Uva Province';
            }
            
            $data['province'] = $province;

            // Handle file upload
            if(!empty($_FILES['profile_image']['name'])) {
                // Get file details
                $file = $_FILES['profile_image'];
                $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                
                // Check if file is an image
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if(in_array($fileType, $allowedTypes)) {
                    // Read the file content
                    $imageContent = file_get_contents($file['tmp_name']);
                    $data['profile_image'] = $imageContent;
                } else {
                    flash('profile_update_error', 'Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.', 'alert alert-danger');
                    header('Location: ' . URLROOT . '/CustomerController/profile');
                    exit;
                }
            } else {
                // If no new image is uploaded, keep the existing one
                $currentUser = $this->CustomerModel->getCustomer($_SESSION['user_id']);
                $data['profile_image'] = $currentUser->profile_image;
            }

            if($this->CustomerModel->updateProfile($data)) {
                flash('profile_update_success', 'Profile updated successfully!');
                header('Location: ' . URLROOT . '/CustomerController/profile');
            } else {
                flash('profile_update_error', 'Failed to update profile', 'alert alert-danger');
                header('Location: ' . URLROOT . '/CustomerController/profile');
            }
        } else {
            header('Location: ' . URLROOT . '/CustomerController/profile');
        }
    }
    
}

?>