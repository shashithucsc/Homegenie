<?php

require_once '../app/models/InventoryModel.php';
require_once '../app/models/SupplierModel.php';

class SupplierController extends Controller {
    private $SupplierModel;
    private $InventoryModel;

    public function __construct() {
        $this->SupplierModel = $this->model('SupplierModel');
        session_regenerate_id();
    }

    public function index() {
        
        $loggedUserId = $_SESSION['user_id'] ?? null;

        if (!$loggedUserId) {
           
            header('Location: /login');
            exit;
        }

      
        $totalSales = $this->SupplierModel->getTotalSales($loggedUserId);
        $yourEarnings = $this->SupplierModel->getYourEarnings($loggedUserId);
        $totalCustomers = $this->SupplierModel->getTotalCustomers($loggedUserId);
        $totalProducts = $this->SupplierModel->getTotalProducts($loggedUserId);
        $topProduct = $this->SupplierModel->getTopProduct($loggedUserId);

       
        $data = [
            'totalSales' => isset($totalSales[0]) ? $totalSales[0]->total_sales : 0,
            'yourEarnings' => isset($yourEarnings) && isset($yourEarnings->yourEarnings) ? $yourEarnings->yourEarnings : 'N/A',
            'totalCustomers' => isset($totalCustomers[0]) ? $totalCustomers[0]->total_customers : 0,
            'totalProducts' => isset($totalProducts[0]) ? $totalProducts[0]->total_products : 0,
            'topProduct' => isset($topProduct[0]) ? $topProduct[0]->item_name : 'N/A',
        ];
        

        
        $this->view('supplier/admin/index', $data);
    }

    public function pendingOrders()
{
    
    $loggedUserId = $_SESSION['user_id'] ?? null;

    if (!$loggedUserId) {
        die('User not logged in.');
    }

   
    $pendingOrders = $this->SupplierModel->getPendingOrders($loggedUserId);

  
    $orders = [];
    foreach ($pendingOrders as $row) {
        $orderId = $row->order_id;
    
        if (!isset($orders[$orderId])) {
            $orders[$orderId] = (object)[
                'order_id' => $row->order_id,
                'customer_id' => $row->customer_id,
                'total_amount' => $row->total_amount,
                'payment_method' => $row->payment_method,
                'delivery_address' => $row->delivery_address,
                'created_at' => $row->created_at,
                'customer_name' => $row->customer_name,
                'contact_number' => $row->contact_number,
                'email' => $row->email,
                'items' => [] 
            ];
        }
    
      
        $orders[$orderId]->items[] = (object)[
            'item_id' => $row->item_id,
            'item_name' => $row->item_name, 
            'quantity' => $row->quantity,
            'price' => $row->price
        ];
    }
    

   
    $data = [
        'pendingOrders' => array_values($orders) 
    ];

    $this->view('supplier/admin/pendingOrders/pendingOrders', $data);
}


public function completedOrders()
{
   
    $loggedUserId = $_SESSION['user_id'] ?? null;

    if (!$loggedUserId) {
        die('User not logged in.');
    }

  
    $completedOrders = $this->SupplierModel->getCompletedOrders($loggedUserId);

   
    $orders = [];
    foreach ($completedOrders as $row) {
        $orderId = $row->order_id;
    
        if (!isset($orders[$orderId])) {
            $orders[$orderId] = (object)[
                'order_id' => $row->order_id,
                'customer_id' => $row->customer_id,
                'total_amount' => $row->total_amount,
                'payment_method' => $row->payment_method,
                'delivery_address' => $row->delivery_address,
                'created_at' => $row->created_at,
                'customer_name' => $row->customer_name,
                'contact_number' => $row->contact_number,
                'email' => $row->email,
                'items' => [] 
            ];
        }
    
        
        $orders[$orderId]->items[] = (object)[
            'item_id' => $row->item_id,
            'item_name' => $row->item_name,
            'quantity' => $row->quantity,
            'price' => $row->price
        ];
    }
    

    // Pass the processed orders to the view
    $data = [
        'completedOrders' => array_values($orders) // Convert associative array to indexed array
    ];

    $this->view('supplier/admin/completedOrders/completedOrders', $data);
}

    
    public function updateOrderStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderId = $_POST['order_id'];
            $status = $_POST['status'];
    
            // Update order status in the database
            $this->SupplierModel->updateOrderStatus($orderId, $status);
    
            // Redirect back to the pending orders page
            header('Location: ' . URLROOT . '/SupplierController/payments');
            exit();
        }
    }
    
    

    public function quotations() {
        $this->view('supplier/admin/Quotations/Quotations');
    }

    public function ratings() {
        $this->view('supplier/admin/Ratings/Ratings');
    }

    public function manageOffers() {
        $model = $this->model('StorePagesModel');
        $offers = $model->getSeasonalOffers();
        $this->view('supplier/admin/manage_offers', ['offers' => $offers]);
    }

    public function addOffer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = $_POST['description'];
            $image = file_get_contents($_FILES['image']['tmp_name']);
            
            $model = $this->model('StorePagesModel');
            $model->addSeasonalOffer($description, $image);
            header("Location: " . URLROOT . "/SupplierController/manageOffers");
        }
    }

    public function updateOffer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['offer_id'];
            $description = $_POST['description'];
            $image = !empty($_FILES['image']['tmp_name']) ? file_get_contents($_FILES['image']['tmp_name']) : null;

            $model = $this->model('StorePagesModel');
            $model->updateSeasonalOffer($id, $description, $image);
            header("Location: " . URLROOT . "/SupplierController/manageOffers");
        }
    }

    public function deleteOffer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['offer_id'];
            $model = $this->model('StorePagesModel');
            $model->deleteSeasonalOffer($id);
            header("Location: " . URLROOT . "/SupplierController/manageOffers");
        }
    }

    public function reports() {
        $loggedUserId = $_SESSION['user_id'] ?? null;

        if (!$loggedUserId) {
            header('Location: /HomeController/login');
            exit;
        }

        // Fetch reports data
        $inventoryReport = $this->SupplierModel->getInventoryReport($loggedUserId);
        $salesReport = $this->SupplierModel->getSalesReport($loggedUserId);
        $reorderSuggestions = $this->SupplierModel->getReorderSuggestions($loggedUserId);

        // Prepare data for the view
        $data = [
            'inventoryReport' => $inventoryReport,
            'salesReport' => $salesReport,
            'reorderSuggestions' => $reorderSuggestions
        ];

        $this->view('supplier/admin/inventory/reports', $data);
    }

    public function saleReport(){
        $loggedUserId = $_SESSION['user_id'] ?? null;

        if(!$loggedUserId){
            header('Location: /HomeController/login');
            exit;
        }

        $salesReport = $this->SupplierModel->getSalesReport($loggedUserId);
        
        $data = [
            'salesReport' => $salesReport
        ];
        $this->view('supplier/admin/salesReport', $data);


    }

    public function profile() {
        // Get the logged-in user_id from the session
        $loggedUserId = $_SESSION['user_id'] ?? null;
    
        if (!$loggedUserId) {
            // Redirect to login if the user is not logged in
            header('Location: /login');
            exit;
        }
    
        // Fetch supplier details and their products using the logged-in user_id
        $supplier = $this->SupplierModel->getSupplierById($loggedUserId);
        $products = $this->SupplierModel->getProductsBySupplier($loggedUserId);
    
        // Check if supplier data exists, else redirect or handle errors
        if (!$supplier) {
            die('Supplier not found.');
        }
    
        // Prepare data for the view
        $data = [
            'supplier' => $supplier,
            'products' => $products,
        ];
    
        // Load the profile view with the data
        $this->view('supplier/admin/profile/Profile', $data);
    }
    
    // Update profile details
    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => $_POST['user_id'],
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'contact_number' => trim($_POST['contact_number']),
                'address' => trim($_POST['address']),
                'expertise' => trim($_POST['expertise']),
                'service_areas' => trim($_POST['service_areas']),
                'message' => '' // Message for the view
            ];

            if ($this->SupplierModel->updateSupplierProfile($data)) {
                $data['message'] = 'Profile updated successfully.';
            } else {
                $data['message'] = 'Error updating profile.';
            }

            // Reload the view with the message
            $supplier = $this->SupplierModel->getSupplierById($data['user_id']);
            $data['supplier'] = $supplier;
            $this->view('supplier/admin/profile/profile', $data);
        } else {
            die('Invalid request.');
        }
    }

    // Update profile picture
    public function updateProfilePicture() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = intval($_POST['user_id']);
            $message = '';
    
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['profile_image']['tmp_name'];
                $fileType = $_FILES['profile_image']['type'];
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    
                if (in_array($fileType, $allowedTypes)) {
                    $profileImage = file_get_contents($fileTmpPath);
                    if ($this->SupplierModel->updateProfilePicture($userId, $profileImage)) {
                        $message = 'Profile picture updated successfully.';
                    } else {
                        $message = 'Error updating profile picture.';
                    }
                } else {
                    $message = 'Invalid file type. Only JPEG, PNG, and GIF are allowed.';
                }
            } else {
                $message = 'Error uploading file.';
            }
    
            // Reload the view with the updated data
            $supplier = $this->SupplierModel->getSupplierById($userId);
            $data = [
                'supplier' => $supplier,
                'message' => $message
            ];
    
            $this->view('supplier/admin/profile/profile', $data);
        } else {
            die('Invalid request.');
        }
    }

    public function storeWithdraw(){
        $this->view('supplier/admin/storeWithdraw');
    }
    
}
