<?php
require_once APPROOT . '/controllers/CartController.php';

class HomeController extends Controller {
    public function index() {
        $mainCardModel = $this->model('MainCardModel');
        $SeasonalOfferBannerModel = $this->model('SeasonalOfferBannerModel');

        $data = $mainCardModel->getPlumbingItems();
        $data1 = $SeasonalOfferBannerModel->getSeasonalOffer();

        $this->view('homepage/index', ['items' => $data, 'data1' => $data1]);
    }
    public function about() {
        echo 'This is about page';
        // $this->view('homepage/about');
    }

    public function navbar() {
        $this->view('navbar/navbar');
    }

    public function home() {
        $this->view('homepage/home');
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

    public function faq() {
        $this->view('homepage/faq');
    }

    public function carpentry() {
        // Load the CarpentryModel
        $carpentryModel = $this->model('carpentryPageModel');
        // Fetch data
        $items = $carpentryModel->getCarpentryItems();
        // Pass data to the view
        $this->view('homepage/carpentry', ['items' => $items]);
    }

    public function electricity() {
        // Load the CarpentryModel
        $carpentryModel = $this->model('electricityPageModel');
        // Fetch data
        $items = $carpentryModel->getElectricityItems();
        // Pass data to the view
        $this->view('homepage/electricity', ['items' => $items]);
    }

    public function masonary() {
        // Load the CarpentryModel
        $carpentryModel = $this->model('masonaryPageModel');
        // Fetch data
        $items = $carpentryModel->getMasonaryItems();
        // Pass data to the view
        $this->view('homepage/masonary', ['items' => $items]);
    }

    public function painting() {
        // Load the CarpentryModel
        $carpentryModel = $this->model('paintingPageModel');
        // Fetch data
        $items = $carpentryModel->getPaintingItems();
        // Pass data to the view
        $this->view('homepage/painting', ['items' => $items]);
    }

    public function cleaning() {
        // Load the CarpentryModel
        $carpentryModel = $this->model('cleaningPageModel');
        // Fetch data
        $items = $carpentryModel->getCleaningItems();
        // Pass data to the view
        $this->view('homepage/cleaning', ['items' => $items]);
    }

    public function getAllWishList() {
        $wishListModel = $this->model('wishListModel');
        $items = $wishListModel->getAllWishList();
        $this->view('homepage/wishList', ['items' => $items]);
    }


}