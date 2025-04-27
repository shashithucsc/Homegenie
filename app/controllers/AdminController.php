<?php
Class AdminController extends Controller{
    private $userModel;
    private $issueModel;
    private $orderModel;
    private $db;
    
    public function __construct() {
        $this->userModel = $this->model('UserModel');
        $this->issueModel = $this->model('IssueModel');
        $this->orderModel = $this->model('OrderModel');

       
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . URLROOT . '/LoginController');
            exit;
        }
        // $this->db = new Database();
    }
    public function index(){
        $loggedUserId = $_SESSION['user_id'] ?? null;

        if (!$loggedUserId) {
            // Handle unauthorized access or redirect to login
            header('Location: ' . URLROOT . '/LoginController');
            exit;
        }

        $data = [
            'adminName' => $_SESSION["username"],
            'userCounts' => $this->userModel->getUserCounts(),
            'pendingVerifications' => $this->userModel->getPendingVerifications(),
            'pendingIssues' => $this->issueModel->getPendingIssuesCount(),
            'totalIssues' => $this->issueModel->getAllIssuesCount(),
            'orderCounts' => $this->orderModel->getOrderCounts(),
            'ordersByStatus' => $this->orderModel->getOrdersByStatus(),
            'userGrowthData' => $this->userModel->getUserGrowthData(),
            'revenueData' => $this->orderModel->getRevenueData(),
            'totalRevenue' => $this->orderModel->getTotalRevenue()
        ];

        $this->view('Admin/AdminDashBoard', $data);
    }

    public function manageUsers(){        
        // Get all users
        $users = $this->userModel->getAllUsers();
        
        $data = [
            'users' => $users
        ];
        $this->view('Admin/ManageUsers', $data);   
    }

    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['user_id'];
            $model = $this->model('UserModel');
            $model->deleteUser($id);
            header("Location: " . URLROOT . "/AdminController/manageUsers");
        }
    }

    public function verifyUsers() {
        // Get unverified service providers using the UserModel
        $unverifiedProviders = $this->userModel->getUnverifiedServiceProviders();
        
        $data = [
            'unverifiedProviders' => $unverifiedProviders
        ];
        
        $this->view('Admin/verifyUsers', $data);
    }

    public function verifyProvider($provider_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Use the UserModel to verify the provider
            if ($this->userModel->verifyServiceProvider($provider_id)) {
                header('Location: ' . URLROOT . '/AdminController/verifyUsers?success=Provider verified successfully');
            } else {
                header('Location: ' . URLROOT . '/AdminController/verifyUsers?error=Failed to verify provider');
            }
            exit();
        }
    }

    public function rejectProvider($provider_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Use the UserModel to reject the provider
            if ($this->userModel->rejectServiceProvider($provider_id)) {
                header('Location: ' . URLROOT . '/AdminController/verifyUsers?success=Provider rejected successfully');
            } else {
                header('Location: ' . URLROOT . '/AdminController/verifyUsers?error=Failed to reject provider');
            }
            exit();
        }
    }

    public function issues() {
        // Load issue model
        $issueModel = $this->model('IssueModel');
        
        // Get all issues with user information
        $issues = $issueModel->getIssues();
        
        $data = [
            'issues' => $issues,
            'adminName' => $_SESSION['user_name'] ?? 'Admin'
        ];
        
        $this->view('Admin/ViewIssues', $data);
    }

    public function markIssueComplete() {
        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get issue ID and reply message from form
            $id = $_POST['issue_id'];
            $replyMessage = $_POST['reply_message'];
            
            // Get issue details including user email
            $issue = $this->issueModel->getIssueById($id);
            
            if ($issue) {
                // Set up email variables
                $to = $issue->email;
                $subject = "Response to your reported issue - HomeGenie";
                
                // Email message
                $message = "Dear " . $issue->first_name . ",<br><br>";
                $message .= "Thank you for bringing this issue to our attention:<br><br>";
                $message .= nl2br($replyMessage) . "<br><br>";
                $message .= "Your issue has been marked as resolved. If you have any further questions, please feel free to contact us.<br><br>";
                $message .= "Best regards,<br>HomeGenie Support Team";
                
                // Replace with your actual email
                $email = "home.genie.team@gmail.com"; 
                $password = "homegenie1234"; 
                
                // Set the email headers
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: $email" . "\r\n";
                
                // For Gmail, you might need to configure your PHP to use SMTP
                ini_set("SMTP", "smtp.gmail.com");
                ini_set("smtp_port", "587");
                ini_set("sendmail_from", $email);
                ini_set("smtp_ssl", "tls");
                
                // Send the email
                mail($to, $subject, $message, $headers);
                
                // Update issue status
                $this->issueModel->markIssueComplete($id);
            }
        }
        
        // Redirect back to issues page
        header("Location: " . URLROOT . "/AdminController/issues");
        exit;
    }

    public function viewOrders(){
        $this->view('Admin/viewOrders');   
    }
    
    public function viewAppointments(){
        // Get all appointments with their related quotation data
        $appointments = $this->userModel->getAllAppointments();
        
        $data = [
            'appointments' => $appointments
        ];
        
        $this->view('Admin/viewAppointments', $data);   
    }
    
    public function faq(){
        // Initialize the FAQ model
        $faqModel = $this->model('FAQModel');
        
        // Check if form was submitted to add a new FAQ
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize POST data
            $data = [
                'topic' => trim($_POST['topic']),
                'content' => trim($_POST['content'])
            ];
            
            // Add FAQ
            if ($faqModel->addFAQ($data)) {
                $_SESSION['success_msg'] = 'FAQ added successfully';
            } else {
                $_SESSION['error_msg'] = 'Something went wrong';
            }
            
            // Redirect to prevent form resubmission
            header('Location: ' . URLROOT . '/AdminController/faq');
            exit;
        }
        
        // Get all FAQs
        $faqs = $faqModel->getAllFAQs();
        
        // Load view with data
        $this->view('Admin/FAQ', ['faqs' => $faqs]);
    } 

    public function editFAQ() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Initialize the FAQ model
            $faqModel = $this->model('FAQModel');
            
            // Sanitize POST data
            $data = [
                'id' => $_POST['id'],
                'topic' => trim($_POST['topic']),
                'content' => trim($_POST['content'])
            ];
            
            // Update FAQ
            if ($faqModel->updateFAQ($data)) {
                $_SESSION['success_msg'] = 'FAQ updated successfully';
            } else {
                $_SESSION['error_msg'] = 'Something went wrong';
            }
            
            // Redirect back to FAQ page
            header('Location: ' . URLROOT . '/AdminController/faq');
            exit;
        }
    }

    public function deleteFAQ($id) {
        // Initialize the FAQ model
        $faqModel = $this->model('FAQModel');
        
        // Delete FAQ
        if ($faqModel->deleteFAQ($id)) {
            $_SESSION['success_msg'] = 'FAQ deleted successfully';
        } else {
            $_SESSION['error_msg'] = 'Something went wrong';
        }
        
        // Redirect back to FAQ page
        header('Location: ' . URLROOT . '/AdminController/faq');
        exit;
    }

    public function getProviderDetails($provider_id) {
        // Get provider details from the model
        $provider = $this->userModel->getProviderDetails($provider_id);
        
        if ($provider) {
            // Return JSON response
            header('Content-Type: application/json');
            echo json_encode($provider);
        } else {
            // Return error
            http_response_code(404);
            echo json_encode(['error' => 'Provider not found']);
        }
        exit();
    }
    
    public function getProviderImage($provider_id, $type) {
        // Get the image from the database
        $image = $this->userModel->getProviderImage($provider_id, $type);
        
        if ($image) {
            // Set the content type to image/jpeg
            header('Content-Type: image/jpeg');
            
            // Output the image
            echo $image;
        } else {
            // If no image is found, redirect to a default image
            header('Location: ' . URLROOT . '/public/img/no-image.jpg');
        }
        exit();
    }
}
?>