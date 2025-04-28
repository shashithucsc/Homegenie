<?php

class CustomerController extends Controller {

    private $CustomerModel;
    private $ContactModel;
    private $ProfileSVPModel;
    public function __construct(){
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
            header('Location: ' . URLROOT . '/LoginController');
            exit;
        }
        $this->CustomerModel = $this->model('CustomerModel');
        $this->ContactModel = $this->model('ContactModel');
        $this->ProfileSVPModel = $this->model('ProfileSVPModel');
    }

    public function index(){
        $this->view('Customer/home');
    }

    public function services(){
        $serviceProviders = $this->CustomerModel->getServiceProviders();
        foreach ($serviceProviders as &$sp) {
            $sp->average_rating = $this->ProfileSVPModel->getAverageRating($sp->user_id);
        }
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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'subject' => trim($_POST['subject']),
                'message' => trim($_POST['message'])
            ];
            
            if (empty($data['full_name']) || empty($data['email']) || empty($data['subject']) || empty($data['message'])) {
                die('Please fill in all required fields.');
            }
            
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
            header('Location: ' . URLROOT . '/LoginController');
            exit;
        }
        $p_appointments = $this->CustomerModel->getPaidAppointments($loggedUserId);
        $f_appointments = $this->CustomerModel->getFinishedAppointments($loggedUserId);
        $customer = $this->CustomerModel->getCustomer($loggedUserId);
        if (!$customer) {
            die('Customer not found.');
        }
        
        $data = [
            'customer' => $customer,
            'p_appointments' => $p_appointments,
            'f_appointments' => $f_appointments
        ];
        $this->view('Customer/cu_profile', $data);
    }
    public function editProfile() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
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
            
            $editprofile = $this->CustomerModel->getProfileById($data['id']);
            
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
        if($id == null){
            header('Location: ' . URLROOT . '/CustomerController/services');
        }
        
        $serviceProvider = $this->CustomerModel->getServiceProviderById($id);
        
        if(!$serviceProvider){
            die('Service provider not found.');
        }
        
        $loggedUserId = $_SESSION['user_id'] ?? null;
        $customer = null;
        if($loggedUserId){
            $customer = $this->CustomerModel->getCustomer($loggedUserId);
        }
        
        $data = [
            'serviceProvider' => $serviceProvider,
            'customer' => $customer
        ];
        
        $this->view('Customer/cu_sp_profile', $data);
    }
    
    public function createAppointment(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
            header('Location: ' . URLROOT . '/CustomerController/SPProfile/' . $data['sp_id']);
        } else {
            header('Location: ' . URLROOT . '/CustomerController/services');
        }
    }

    public function editAppointment() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'id' => $_POST['id'],
                'date' => $_POST['date'],
                'time' => $_POST['time'],
                'notes' => $_POST['notes'],
                'customer_id' => $_SESSION['user_id']
            ];
            
            $appointment = $this->CustomerModel->getAppointmentById($data['id']);
            
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
        if($id == null) {
            header('Location: ' . URLROOT . '/CustomerController/appointment');
            exit;
        }
        
        $appointment = $this->CustomerModel->getAppointmentById($id);
        
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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
            $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
            
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
        $appointment = $this->CustomerModel->getAppointmentById($appointment_id);
        
        if(!$appointment || $appointment->customer_id != $_SESSION['user_id']) {
            flash('payment_error', 'Unauthorized access or appointment not found', 'alert alert-danger');
            header('Location: ' . URLROOT . '/CustomerController/appointment');
            exit;
        }

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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'appointment_id' => $_POST['appointment_id'],
                'amount' => $_POST['amount']
            ];

            if($this->CustomerModel->createTransaction($data['appointment_id'], $data['amount'])) {
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
            
            $district = $data['district'];
            $province = '';
            
            if (in_array($district, ['Colombo', 'Gampaha', 'Kalutara'])) {
                $province = 'Western Province';
            }
            else if (in_array($district, ['Kandy', 'Matale', 'Nuwara Eliya'])) {
                $province = 'Central Province';
            }
            else if (in_array($district, ['Galle', 'Matara', 'Hambantota'])) {
                $province = 'Southern Province';
            }
            else if (in_array($district, ['Ampara', 'Batticaloa', 'Trincomalee'])) {
                $province = 'Eastern Province';
            }
            else if (in_array($district, ['Jaffna', 'Kilinochchi', 'Mullaitivu', 'Vavuniya', 'Mannar'])) {
                $province = 'Northern Province';
            }
            else if (in_array($district, ['Kurunegala', 'Puttalam'])) {
                $province = 'North Western Province';
            }
            else if (in_array($district, ['Anuradhapura', 'Polonnaruwa'])) {
                $province = 'North Central Province';
            }
            else if (in_array($district, ['Kegalle', 'Ratnapura'])) {
                $province = 'Sabaragamuwa Province';
            }
            else if (in_array($district, ['Badulla', 'Monaragala'])) {
                $province = 'Uva Province';
            }
            
            $data['province'] = $province;

            if(!empty($_FILES['profile_image']['name'])) {
                $file = $_FILES['profile_image'];
                $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if(in_array($fileType, $allowedTypes)) {
                    $imageContent = file_get_contents($file['tmp_name']);
                    $data['profile_image'] = $imageContent;
                } else {
                    flash('profile_update_error', 'Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.', 'alert alert-danger');
                    header('Location: ' . URLROOT . '/CustomerController/profile');
                    exit;
                }
            } else {
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