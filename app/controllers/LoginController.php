<?php
class LoginController extends Controller
{
    private $UserModel;
    public function __construct()
    {
        $this->UserModel = $this->model('UserModel');
        session_regenerate_id(true);
    }

    public function index()
    {
        $this->view('users/v_login');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize input
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter your email address.';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a valid email address.';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter your password.';
            }

            // Attempt login if no errors
            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->UserModel->login($data['email'], $data['password']);
                if ($loggedInUser) {
                    // Set session variables
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $loggedInUser->user_id;
                    $_SESSION['email'] = $loggedInUser->email;
                    $_SESSION['role'] = $loggedInUser->role;
                    $_SESSION['username'] = $loggedInUser->first_name . ' ' . $loggedInUser->last_name;

                    // Redirect based on role
                    $redirectUrl = match ($loggedInUser->role) {
                        'customer' => URLROOT . '/CustomerController/index',
                        'service_provider' => URLROOT . '/ServiceProviderController',
                        'supplier' => URLROOT . '/SupplierController',
                        'admin' => URLROOT . '/AdminController',
                        default => URLROOT . '/HomeController'
                    };
                    header('Location: ' . $redirectUrl);
                    exit();
                } else {
                    $data['password_err'] = 'Incorrect email or password.';
                }
            }

            // Load view with errors
            $this->view('users/v_login', $data);
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            $this->view('users/v_login', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['email']);
        unset($_SESSION['role']);
        unset($_SESSION['username']);
        session_destroy();
        header('Location: ' . URLROOT . '/users/login');
        exit();
    }


    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = trim($_POST['role']);
    
            // Common fields
            $data = [
                'role' => $role,
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'contact_number' => trim($_POST['contact_number']),
                'province' => trim($_POST['province']),
                'district' => trim($_POST['district']),
                'street' => trim($_POST['street']),
                'agree_terms' => isset($_POST['agree_terms']) ? 1 : 0,
                'profile_image' => ($role === 'customer') ? null : $this->processImageUpload($_FILES['profile_image'])
     

            ];
    
            // First validate common fields
            $missingFields = $this->validateCommonFields($data);
            if (!empty($missingFields)) {
                $this->showPopup("Please fill in all required fields: " . implode(', ', $missingFields), URLROOT . '/register');
                return;
            }
    
            // Validate role-specific fields
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
                    'work_photos' => $this->processMultipleImages($_FILES['work_photos'])
                ];
    
                $missingProviderFields = $this->validateServiceProviderFields($serviceProviderData);
                if (!empty($missingProviderFields)) {
                    $this->showPopup("Please fill in all service provider fields: " . implode(', ', $missingProviderFields), URLROOT . '/register');
                    return;
                }
            } elseif ($role === 'supplier') {
                $supplierData = [
                    'expertise' => trim($_POST['expertise']),
                    'NIC' => trim($_POST['id_number']), // Changed from NIC to id_number
                    'bank_details' => trim($_POST['bank_details']),
                    'id_front_photo' => $this->processImageUpload($_FILES['id_front']), // Changed from id_front_photo
                    'id_back_photo' => $this->processImageUpload($_FILES['id_back'])    // Changed from id_back_photo
                ];
    
                $missingSupplierFields = $this->validateSupplierFields($supplierData);
                if (!empty($missingSupplierFields)) {
                    $this->showPopup("Please fill in all supplier fields: " . implode(', ', $missingSupplierFields), URLROOT . '/register');
                    return;
                }
            }
    
            // Validate passwords, email, etc.
            if ($data['password'] !== $data['confirm_password']) {
                $this->showPopup("Passwords do not match", URLROOT . '/LoginController/index');
                return;
            }
    
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->showPopup("Invalid email format", URLROOT . '/LoginController/index');
                return;
            }
    
            if ($this->UserModel->isEmailTaken($data['email'])) {
                $this->showPopup("Email is already taken", URLROOT . '/LoginController/index');
                return;
            }
    
            // Hash password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    
            // Register user (insert into users table)
            $userId = $this->UserModel->registerUser($data);
            
            // Add error handling to debug the issue
            if (!$userId) {
                error_log("User registration failed: " . print_r($data, true));
                $this->showPopup("Error registering user. Please check logs.", URLROOT . '/LoginController/index');
                return;
            }
    
            // Insert into role-specific tables
            if ($role === 'service_provider') {
                $serviceProviderData['provider_id'] = $userId;
                $success = $this->UserModel->registerServiceProvider($serviceProviderData);
    
                if ($success) {
                    $this->showPopup("Registration successful! Please wait for admin approval.", URLROOT . '/LoginController/index');
                } else {
                    $this->showPopup("Error registering service provider details", URLROOT . '/LoginController/index');
                }
            } elseif ($role === 'supplier') {
                // Here's the fix - pass user_id directly rather than supplier_id
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
            $this->view('register/index');
        }
    }
}
    // Add this new method to handle multiple images
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
        return !empty($images) ? implode('|||', $images) : null; // Using a delimiter to separate multiple images
    }



    // Validate common fields
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
    
        // Only check profile image for non-customer roles
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
        // Only validate service provider specific fields
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
        // Only validate supplier specific fields
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

        $data = ['message' => $message, 'redirectUrl' => $redirectUrl];
        $this->view('users/v_login', $data);
    }





}
