<?php

require_once '../models/MainCardModel.php';

class MainCardController {
    private $mainCardModel;

    public function __construct() {
        $this->mainCardModel = new MainCardModel();
    }

    public function index() {
        $data = $this->mainCardModel->getPlumbingItems();
        

    }
}


$controller = new MainCardController();
$controller->index();


