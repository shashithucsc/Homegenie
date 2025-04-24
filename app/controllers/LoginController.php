<?php
class LoginController extends Controller {
    private $UserModel;
    public function __construct() {
        $this->UserModel = $this->model('UserModel');
        session_regenerate_id(true);
    }

    public function index() {
        $this->view('users/v_login');
    }

    public function login() {
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

    public function logout() {
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
        $data = [
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'contact_number' => trim($_POST['contact_number']),
            'address' => trim($_POST['address']),
            'agree_terms' => isset($_POST['agree_terms']) ? 1 : 0, // Added terms checkbox
        ];

        // 1. Validate required fields
        $missingFields = $this->validateCommonFields($data);
        if (!empty($missingFields)) {
            $this->showPopup("Please fill in all required fields: " . implode(', ', $missingFields), URLROOT . '/register');
            return;
        }

        // 2. Password Match Check
        if ($data['password'] !== $data['confirm_password']) {
            $this->showPopup("Passwords do not match", URLROOT . '/register');
            return;
        }

        // 3. Email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->showPopup("Invalid email format", URLROOT . '/register');
            return;
        }

        // 4. Unique Email Check
        if ($this->UserModel->isEmailTaken($data['email'])) {
            $this->showPopup("Email is already taken", URLROOT . '/register');
            return;
        }

        // 5. Password Hash
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $userId = $this->UserModel->registerUser([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'contact_number' => $data['contact_number'],
            'email' => $data['email'],
            'address' => $data['address'],
            'password' => $hashedPassword,
            'role' => 'customer',
            'agree_terms' => $data['agree_terms'],
        ]);
        
        if (!$userId) {
            $this->showPopup("Error registering user", URLROOT . '/register');
            return;
        }
        
        // ✅ Don't insert again here. It's already done in the model.
        
        $this->showPopup("Registration successful", URLROOT . '/LoginController/index');
            } else {
        $this->view('register/index');
    }
}

// Validate common fields
private function validateCommonFields($data)
{
    $required = ['first_name', 'last_name', 'email', 'password', 'confirm_password', 'contact_number', 'address'];
    $missing = [];

    foreach ($required as $field) {
        if (empty($data[$field])) {
            $missing[] = $field;
        }
    }
    return $missing;
}

private function showPopup($message, $redirectUrl)
    {
      
        $data = ['message' => $message, 'redirectUrl' => $redirectUrl];
        $this->view('supplier/homepage/cartElements/popup', $data);
    }

}
