<?php
Class AdminController extends Controller{
    private $userModel;
    private $issueModel;
    private $orderModel;
    
    public function __construct() {
        $this->userModel = $this->model('UserModel');
        $this->issueModel = $this->model('IssueModel');
        $this->orderModel = $this->model('OrderModel');
    }
    public function index(){
        $loggedUserId = $_SESSION['user_id'] ?? null;

        if (!$loggedUserId) {
            // Handle unauthorized access or redirect to login
            header('Location: /login');
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
        // Check if admin is logged in
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            redirect('users/login');
            exit;
        }
        
        // Get all users
        $users = $this->userModel->getAllUsers();
        
        $data = [
            'users' => $users
        ];
        $this->view('Admin/ManageUsers', $data);   
    } 

    public function searchUsers() {
        // Check if admin is logged in
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            redirect('users/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $searchTerm = trim($_POST['search']);
            
            $users = $this->userModel->searchUsers($searchTerm);
            
            $data = [
                'users' => $users
            ];
            
            $this->view('Admin/ManageUsers', $data);
        } else {
            redirect('admin/manageUsers');
        }
    }
    
    public function deleteUser($id) {
        // Check if admin is logged in
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            redirect('users/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Delete the user
            if ($this->userModel->deleteUser($id)) {
                flash('user_message', 'User deleted successfully');
                redirect('admin/manageUsers');
            } else {
                flash('user_message', 'Something went wrong when deleting the user', 'alert alert-danger');
                redirect('admin/manageUsers');
            }
        } else {
            redirect('admin/manageUsers');
        }
    }

    public function verifyUsers(){
        $this->view('Admin/verifyUsers');   
    }

    public function viewIsuues(){
        $this->view('Admin/ViewIssues');   
    } 

    public function viewOrders(){
        $this->view('Admin/viewOrders');   
    } 
    
    public function faq(){
        $this->view('Admin/FAQ');   
    } 
    

}
?>