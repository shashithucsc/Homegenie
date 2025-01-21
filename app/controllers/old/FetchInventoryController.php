<?php
class FetchInventoryController extends Controller {
    private $inventoryModel;

    public function __construct() {
        $this->inventoryModel = $this->model('InventoryModel');
    }

    public function fetch() {
        echo json_encode($this->inventoryModel->getAllItems());
    }
}
?>
