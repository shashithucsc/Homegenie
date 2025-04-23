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
        // Check if admin is logged in
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . URLROOT . '/LoginController');
            exit;
        }
        
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