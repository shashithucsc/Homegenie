<?php
class InventoryController extends Controller {
    private $inventoryModel;

    public function __construct() {
        $this->inventoryModel = $this->model('InventoryModel');
    }

    public function index() {
        $results = $this->inventoryModel->getAllItems();
        $this->view('admin/inventory/inventory', $results);
    }

    
    
}
?>
