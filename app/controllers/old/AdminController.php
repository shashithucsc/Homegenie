<?php
class AdminController extends Controller {

    public function index() {
        // Load the view for the admin dashboard
        $this->view('admin/index');
    }

    public function Dashboard() {
        // Load the view for the admin dashboard
        $this->view('admin/index');
    }

    // public function inventory() {
    //     // Load the view for the inventory page
    //     $this->view('admin/inventory/inventory');
    // }

    public function payments() {
        // Load the view for the payments page
        $this->view('admin/Payments/Payments');
    }

    public function quotations() {
        // Load the view for the quotations page
        $this->view('admin/Quotations/Quotations');
    }

    public function ratings() {
        // Load the view for the ratings page
        $this->view('admin/Ratings/Ratings');
    }

    // public function profile() {
    //     // Load the view for the profile page
    //     $this->view('admin/Profile/Profile');
    // }

    public function manageOffers() {
        $model = $this->model('SeasonalOfferModel');
        $offers = $model->getSeasonalOffers();
        $this->view('admin/manage_offers', ['offers' => $offers]);
    }

    public function addOffer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = $_POST['description'];
            $image = file_get_contents($_FILES['image']['tmp_name']);
            
            $model = $this->model('SeasonalOfferModel');
            $model->addSeasonalOffer($description, $image);
            header("Location: " . URLROOT . "/AdminController/manageOffers");
        }
    }

    public function updateOffer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['offer_id'];
            $description = $_POST['description'];
            $image = !empty($_FILES['image']['tmp_name']) ? file_get_contents($_FILES['image']['tmp_name']) : null;

            $model = $this->model('SeasonalOfferModel');
            $model->updateSeasonalOffer($id, $description, $image);
            header("Location: " . URLROOT . "/AdminController/manageOffers");
        }
    }

    public function deleteOffer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['offer_id'];

            $model = $this->model('SeasonalOfferModel');
            $model->deleteSeasonalOffer($id);
            header("Location: " . URLROOT . "/AdminController/manageOffers");
        }
    }

    public function reports() {
        // Load the view for the reports page
        $this->view('admin/inventory/reports');
    }

    public function supplierProfile($supplier_id) {
        // Load the SupplierModel
        $model = $this->model('SupplierModel');
        
        // Get supplier and product data
        $supplier = $model->getSupplierById($supplier_id);
        $products = $model->getProductsBySupplierId($supplier_id);
    
        $data = [
            'supplier' => $supplier,
            'products' => $products
        ];
    
        // Load the view
        $this->view('admin/supplier/profile', $data);
    }
    

   

}
