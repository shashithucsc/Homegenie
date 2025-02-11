<?php
Class HomeController extends Controller {

    private $CustomerModel;
    public function __construct(){
        $this->CustomerModel = $this->model('CustomerModel');
    }

    public function index(){
        $this->view('LandingPage/index');
    }

    public function services(){
        $serviceProviders = $this->CustomerModel->getServiceProviders();
        if (!$serviceProviders) {
            die('No service providers found.');
        }
        $data = [
            'serviceProviders' => $serviceProviders
        ];
        $this->view('LandingPage/services', $data);
    }

    public function about(){
        $this->view('LandingPage/about');
    }

    public function contact(){
        $this->view('LandingPage/contact');
    }
   
}
?>