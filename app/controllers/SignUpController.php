<?php
class SignUpController extends Controller {

    private $UserModel;
    private $ExpertiseModel;
    
    public function __construct()
    {
        $this->UserModel = $this->model('UserModel');
        $this->ExpertiseModel = $this->model('ExpertiseModel');
        session_regenerate_id(true);
    }

   

    public function customer() {
        $this->view('users/v_register_cu');
    }

    public function supplier() {
        $this->view('users/v_register_su');
    }

    public function provider() {
        $data = [
            'expertise_list' => $this->ExpertiseModel->getAllExpertise()
        ];
        $this->view('users/v_register_sp', $data);
    }

    public function register(){
        
    }

    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = trim($_POST['role']);
            $district = trim($_POST['district']);
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
    
            $data = [
                'role' => $role,
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'contact_number' => trim($_POST['contact_number']),
                'province' => $province,
                'district' => trim($_POST['district']),
                'street' => trim($_POST['street']),
                'agree_terms' => isset($_POST['agree_terms']) ? 1 : 0,
                'profile_image' => ($role === 'customer') ? null : $this->processImageUpload($_FILES['profile_image'])
            ];
    
            $missingFields = $this->validateCommonFields($data);
            if (!empty($missingFields)) {
                $this->showPopup("Please fill in all required fields: " . implode(', ', $missingFields), URLROOT . '/register');
                return;
            }
    
            if ($role === 'service_provider') {              
                $serviceProviderData = [
                    'expertise' => trim($_POST['expertise']),
                    'description' => trim($_POST['description']),
                    'working_hours' => trim($_POST['working_hours']),
                    'service_areas' => trim($_POST['service_areas']),
                    'id_number' => trim($_POST['id_number']),
                    'bank_details' => trim($_POST['bank_details']),
                    'id_front' => $this->processImageUpload($_FILES['id_front']),
                    'id_back' => $this->processImageUpload($_FILES['id_back']),
                    'work_photos' => ""
                ];
                
    
                $missingProviderFields = $this->validateServiceProviderFields($serviceProviderData);
                if (!empty($missingProviderFields)) {
                    $this->showPopup("Please fill in all service provider fields: " . implode(', ', $missingProviderFields), URLROOT . '/register');
                    return;
                }
            } elseif ($role === 'supplier') {
                $supplierData = [
                    'expertise' => trim($_POST['expertise']),
                    'NIC' => trim($_POST['id_number']),
                    'bank_details' => trim($_POST['bank_details']),
                    'id_front_photo' => $this->processImageUpload($_FILES['id_front']),
                    'id_back_photo' => $this->processImageUpload($_FILES['id_back']) 
                ];
    
                $missingSupplierFields = $this->validateSupplierFields($supplierData);
                if (!empty($missingSupplierFields)) {
                    $this->showPopup("Please fill in all supplier fields: " . implode(', ', $missingSupplierFields), URLROOT . '/register');
                    return;
                }
            }
        
            error_log("Checking if email is taken: " . $data['email']);
            if ($this->UserModel->isEmailTaken($data['email'])) {
                error_log("Email is already taken: " . $data['email']);
                $this->showPopup("Email is already taken", URLROOT . '/LoginController/index');
                return;
            }
            error_log("Email is not taken, proceeding with registration");
    
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    
            $userId = $this->UserModel->registerUser($data);
            
            if (!$userId) {
                error_log("User registration failed: " . print_r($data, true));
                $this->showPopup("Error registering user. Please check logs.", URLROOT . '/LoginController/index');
                return;
            }
    
            if ($role === 'service_provider') {
                $serviceProviderData['provider_id'] = $userId;
                $success = $this->UserModel->registerServiceProvider($serviceProviderData);
    
                if ($success) {
                    $this->showPopup("Registration successful! Please wait for admin approval.", URLROOT . '/LoginController/index');
                } else {
                    $this->showPopup("Error registering service provider details", URLROOT . '/LoginController/index');
                }
            } elseif ($role === 'supplier') {
                $success = $this->UserModel->registerSupplier($userId, $supplierData);
    
                if ($success) {
                    $this->showPopup("Registration successful! Please wait for admin approval.", URLROOT . '/LoginController/index');
                } else {
                    $this->showPopup("Error registering supplier details", URLROOT . '/LoginController/index');
                }
            } elseif ($role === 'customer') {
                $success = $this->UserModel->registerCustomer($userId);
                
                if ($success) {
                    $this->showPopup("Registration successful!", URLROOT . '/LoginController/index');
                } else {
                    $this->showPopup("Error registering customer details", URLROOT . '/LoginController/index');
                }
        } else {
            if($role === 'customer'){
                $this->view('users/v_register_cu');
            }elseif($role === 'supplier'){
                $this->view('users/v_register_su');
            }elseif($role === 'service_provider'){
                $this->view('users/v_register_sp');
            }
        }
    }
}
    private function processMultipleImages($files)
    {
        $images = [];
        if (is_array($files['tmp_name'])) {
            foreach ($files['tmp_name'] as $key => $tmp_name) {
                if ($files['error'][$key] === UPLOAD_ERR_OK) {
                    $images[] = file_get_contents($tmp_name);
                }
            }
        }
        return !empty($images) ? implode('|||', $images) : null; 
    }

    private function validateCommonFields($data)
    {
        $required = [
            'first_name',
            'last_name',
            'email',
            'password',
            'confirm_password',
            'contact_number',
            'province',
            'district',
            'street'
        ];
    
        $missing = [];
    
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $missing[] = $field;
            }
        }
    
        if ($data['role'] !== 'customer' && empty($data['profile_image'])) {
            $missing[] = 'profile_image';
        }
    
        return $missing;
    }


    private function processImageUpload($file)
    {
        if ($file['error'] === UPLOAD_ERR_OK) {
            return file_get_contents($file['tmp_name']);
        }
        return null;
    }

    private function validateServiceProviderFields($serviceProviderData)
    {
        $required = [
            'expertise',
            'working_hours',
            'service_areas',
            'id_number',
            'bank_details',
            'id_front',
            'id_back'
        ];

        $missing = [];

        foreach ($required as $field) {
            if (empty($serviceProviderData[$field])) {
                $missing[] = $field;
            }
        }

        return $missing;
    }

    public function validateSupplierFields($supplierData)
    {
        $required = [
            'expertise',
            'NIC',
            'id_front_photo',
            'id_back_photo',
            'bank_details'
        ];
    
        $missing = [];
    
        foreach ($required as $field) {
            if (empty($supplierData[$field])) {
                $missing[] = $field;
            }
        }
    
        return $missing;
    }


    private function showPopup($message, $redirectUrl)
    {
        error_log("Showing popup with message: " . $message . " and redirect URL: " . $redirectUrl);
        $data = ['message' => $message, 'redirectUrl' => $redirectUrl];
        $this->view('users/v_login', $data);
    }
}    