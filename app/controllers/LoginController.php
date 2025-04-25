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


    




}
