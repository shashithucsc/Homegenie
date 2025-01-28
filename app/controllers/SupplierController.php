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
        // Get the logged-in user_id from the session
        $loggedUserId = $_SESSION['user_id'] ?? null;

        if (!$loggedUserId) {
            // Handle unauthorized access or redirect to login
            header('Location: /login');
            exit;
        }

        // Fetch data from the models for the logged user
        $totalSales = $this->SupplierModel->getTotalSales($loggedUserId);
        $totalCustomers = $this->SupplierModel->getTotalCustomers($loggedUserId);
        $totalProducts = $this->SupplierModel->getTotalProducts($loggedUserId);
        $topCategory = $this->SupplierModel->getTopCategory($loggedUserId);
        $topProduct = $this->SupplierModel->getTopProduct($loggedUserId);

        // Check and assign values safely, using 'N/A' fallback if necessary
        $data = [
            'totalSales' => isset($totalSales[0]) ? $totalSales[0]->total_sales : 0,
            'totalCustomers' => isset($totalCustomers[0]) ? $totalCustomers[0]->total_customers : 0,
            'totalProducts' => isset($totalProducts[0]) ? $totalProducts[0]->total_products : 0,
            'topCategory' => isset($topCategory[0]) ? $topCategory[0]->category : 'N/A',
            'topProduct' => isset($topProduct[0]) ? $topProduct[0]->item_name : 'N/A',
        ];

        // Pass the data to the view
        $this->view('admin/index', $data);
    }

    public function payments()
{
    // Check if the user is logged in
    $loggedUserId = $_SESSION['user_id'] ?? null;

    if (!$loggedUserId) {
        die('User not logged in.');
    }

    // Fetch pending orders
    $pendingOrders = $this->SupplierModel->getPendingOrders($loggedUserId);

    // Process the orders to group items
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
                'items' => [] // Initialize an empty items array
            ];
        }
    
        // Add item details, including item_name, to the order
        $orders[$orderId]->items[] = (object)[
            'item_id' => $row->item_id,
            'item_name' => $row->item_name, // Add item_name here
            'quantity' => $row->quantity,
            'price' => $row->price
        ];
    }
    

    // Pass the processed orders to the view
    $data = [
        'pendingOrders' => array_values($orders) // Convert associative array to indexed array
    ];

    $this->view('admin/pendingOrders/pendingOrders', $data);
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
        $this->view('admin/Quotations/Quotations');
    }

    public function ratings() {
        $this->view('admin/Ratings/Ratings');
    }

    public function manageOffers() {
        $model = $this->model('StorePagesModel');
        $offers = $model->getSeasonalOffers();
        $this->view('admin/manage_offers', ['offers' => $offers]);
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
            header('Location: /login');
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

        $this->view('admin/inventory/reports', $data);
    }

    public function supplierProfile($user_id = null) {
        if (is_null($user_id)) {
            die('Error: Supplier ID is required');
        }

        $supplier = $this->SupplierModel->getSupplierById($user_id);
        $products = $this->SupplierModel->getProductsBySupplierId($user_id);

        $data = [
            'supplier' => $supplier,
            'products' => $products
        ];

        $this->view('admin/profile/profile', $data);
    }
}
