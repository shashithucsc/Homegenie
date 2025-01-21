<?php
require_once '../app/models/TestModel.php';

class TestController {
    private $TestModel;

    public function __construct() {
      
        $this->TestModel = new TestModel();
    }

    public function index() {
        // Fetch data from the model
        $data = $this->TestModel->test();

        // Load the view and pass the data
        $this->view('test/index', $data);
    }

  

}
?>
