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

    public function SPProfile($id = null){
        if ($id === null) {
            die('No ID provided');
        }
        // Get service provider details
        $serviceProvider = $this->CustomerModel->getServiceProviderById($id);
        
        if(!$serviceProvider){
            die('Service provider not found.');
        }
        
        // Prepare data for the view
        $data = [
            'serviceProvider' => $serviceProvider,
        ];
        
        $this->view('LandingPage/sp_profile', $data);
    }

    public function about(){
        $this->view('LandingPage/about');
    }

    public function contact(){
        $this->view('LandingPage/contact');
    }
   
}
?>