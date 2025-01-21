<?php
class RemoveInventoryController extends Controller {
    private $inventoryModel;

    public function __construct() {
        $this->inventoryModel = $this->model('InventoryModel');
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $itemId = trim($_POST['item_id']);

            // Delete item
            if ($this->inventoryModel->deleteItem($itemId)) {
                header('Location: ' . URLROOT . '/InventoryController');
            } else {
                die('Something went wrong.');
            }
        } else {
            header('Location: ' . URLROOT . '/InventoryController');
        }
    }
}
