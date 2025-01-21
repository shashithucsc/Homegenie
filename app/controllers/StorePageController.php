<?php
require_once APPROOT . '/controllers/CartController.php';

class StorePageController extends Controller {
    public function index() {
        $storePagesModel = $this->model('StorePagesModel');
        $data = $storePagesModel->getPlumbingItems();
        $data1 = $storePagesModel->getSeasonalOffers();
        $this->view('homepage/index', ['items' => $data, 'data1' => $data1]);
    }

    public function navbar() {
        $this->view('navbar/navbar');
    }

    public function wishlist() {
        $this->view('homepage/wishlist');
    }

    public function yourCart() {
        $CartController = new CartController();
        $CartController->viewCart();

    }

    public function contact() {
        $this->view('homepage/contact');
    }

    public function aboutUs() {
        $this->view('homepage/about');
    }

    public function carpentry() {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getCarpentryItems();
        $this->view('homepage/carpentry', ['items' => $items]);
    }

    public function electricity() {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getElectricityItems();
        $this->view('homepage/electricity', ['items' => $items]);
    }

    public function masonary() {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getMasonaryItems();
        $this->view('homepage/masonary', ['items' => $items]);
    }

    public function painting() {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getPaintingItems();
        $this->view('homepage/painting', ['items' => $items]);
    }

    public function cleaning() {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getCleaningItems();
        $this->view('homepage/cleaning', ['items' => $items]);
    }

    public function getAllWishList() {
        $wishListModel = $this->model('wishListModel');
        $items = $wishListModel->getAllWishList();
        $this->view('homepage/wishList', ['items' => $items]);
    }

}    