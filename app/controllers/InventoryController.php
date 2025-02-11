<?php
class InventoryController extends Controller {
    private $inventoryModel;

    public function __construct() {
        $this->inventoryModel = $this->model('InventoryModel');
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            die("User not logged in.");
        }
    
        $user_id = $_SESSION['user_id'];
        $results = $this->inventoryModel->getAllItems($user_id);
        $this->view('supplier/admin/inventory/inventory', $results);
    }

    public function add() {
        $this->view('supplier/admin/inventory/add');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'item_name' => $_POST['item_name'],
                'quantity' => $_POST['quantity'],
                'selling_price' => $_POST['selling_price'],
                'category' => $_POST['category'],
                'added_date' => $_POST['date'],
                'image' => file_get_contents($_FILES["image"]["tmp_name"])
            ];

            if ($this->inventoryModel->addItem($data)) {
                header('Location: ' . URLROOT . '/InventoryController');
            } else {
                die("Error: Unable to add item.");
            }
        }
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

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
?>
