<?php
class UpdateInventoryController extends Controller {
    private $inventoryModel;

    public function __construct() {
        $this->inventoryModel = $this->model('InventoryModel');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $data = [
                'item_id' => trim($_POST['item_id']),
                'price' => trim($_POST['price']),
            ];
    
            // Validate the price
            if ($data['price'] <= 0) {
                die('Error: Price must be greater than zero.');
            }
    
            // Update item price
            if ($this->inventoryModel->updateItemPrice($data)) {
                header('Location: ' . URLROOT . '/InventoryController');
            } else {
                die('Something went wrong.');
            }
        } else {
            header('Location: ' . URLROOT . '/InventoryController');
        }
    }
    
}
