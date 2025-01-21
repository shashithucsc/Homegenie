<?php
class AddInventoryController extends Controller {
    private $inventoryModel;

    public function __construct() {
        $this->inventoryModel = $this->model('InventoryModel');
    }

    public function index() {
        // Load the form view
        $this->view('admin/inventory/add');
    }

    public function store() {
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
}
?>
