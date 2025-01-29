<?php
require_once APPROOT . '/controllers/CartController.php';

class StorePageController extends Controller {


   private $StorePagesModel;

    public function __construct() {
        $this->StorePagesModel = $this->model('StorePagesModel');
    }
    public function index() {
        $storePagesModel = $this->model('StorePagesModel');
        $data = $storePagesModel->getPlumbingItems();
        $data1 = $storePagesModel->getSeasonalOffers();
        $this->view('supplier/homepage/index', ['items' => $data, 'data1' => $data1]);
    }

    public function navbar() {
        $this->view('navbar/navbar');
    }

    public function wishlist() {
        $this->view('supplier/homepage/wishlist');
    }

    public function yourCart() {
        $CartController = new CartController();
        $CartController->viewCart();

    }

    public function contact() {
        $this->view('supplier/homepage/contact');
    }

    public function aboutUs() {
        $this->view('supplier/homepage/about');
    }

    public function carpentry() {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getCarpentryItems();
        $this->view('supplier/homepage/carpentry', ['items' => $items]);
    }

    public function electricity() {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getElectricityItems();
        $this->view('supplier/homepage/electricity', ['items' => $items]);
    }

    public function masonary() {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getMasonaryItems();
        $this->view('supplier/homepage/masonary', ['items' => $items]);
    }

    public function painting() {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getPaintingItems();
        $this->view('supplier/homepage/painting', ['items' => $items]);
    }

    public function cleaning() {
        $carpentryModel = $this->model('StorePagesModel');
        $items = $carpentryModel->getCleaningItems();
        $this->view('supplier/homepage/cleaning', ['items' => $items]);
    }

    public function getAllWishList() {
        $wishListModel = $this->model('wishListModel');
        $items = $wishListModel->getAllWishList();
        $this->view('supplier/homepage/wishList', ['items' => $items]);
    }

    public function search() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $searchQuery = filter_input(INPUT_POST, 'search_query', FILTER_SANITIZE_STRING);
            if (!empty($searchQuery)) {
                $items = $this->StorePagesModel->searchItems($searchQuery);
                $data = ['items' => $items];
                $this->view('supplier/homepage/index', $data);
            } else {
                header('Location: ' . URLROOT . '/StorePageController/index');
                exit();
            }
        } else {
            header('Location: ' . URLROOT . '/StorePageController/index');
            exit();
        }
    }

}    