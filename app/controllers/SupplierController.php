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
    $SupplierModel = $this->model('SupplierModel');
    
    

    // Get the logged-in user_id from the session
    $loggedUserId = $_SESSION['user_id'] ?? null;

    if (!$loggedUserId) {
        // Handle unauthorized access or redirect to login
        header('Location: /login');
        exit;
    }

    // Fetch data from the models for the logged user
    $totalSales = $SupplierModel->getTotalSales($loggedUserId);
    $totalCustomers = $SupplierModel->getTotalCustomers($loggedUserId);
    $totalProducts = $SupplierModel->getTotalProducts($loggedUserId);
    $topCategory = $SupplierModel->getTopCategory($loggedUserId);
    $topProduct = $SupplierModel->getTopProduct($loggedUserId);

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
 

    public function payments() {
        $this->view('admin/Payments/Payments');
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
        $SupplierModel = $this->model('SupplierModel');
        $loggedUserId = $_SESSION['user_id'] ?? null;
    
        if (!$loggedUserId) {
            header('Location: /login');
            exit;
        }
    
        // Fetch reports data
        $inventoryReport = $SupplierModel->getInventoryReport($loggedUserId);
        $salesReport = $SupplierModel->getSalesReport($loggedUserId);
        $reorderSuggestions = $SupplierModel->getReorderSuggestions($loggedUserId);
    
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
    
        $model = $this->model('SupplierModel');
        $supplier = $model->getSupplierById($user_id);
        $products = $model->getProductsBySupplierId($user_id);
    
        $data = [
            'supplier' => $supplier,
            'products' => $products
        ];
    
        $this->view('admin/profile/profile', $data);
    }

    }
