<?php
Class HomeController extends Controller {

    private $CustomerModel;
    private $ContactModel;
    public function __construct(){
        $this->CustomerModel = $this->model('CustomerModel');
        $this->ContactModel = $this->model('ContactModel');
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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'subject' => trim($_POST['subject']),
                'message' => trim($_POST['message'])
            ];
            
            // Validate data
            if (empty($data['full_name']) || empty($data['email']) || empty($data['subject']) || empty($data['message'])) {
                die('Please fill in all required fields.');
            }
            
            // Send message to the database
            if ($this->ContactModel->createContact($data)) {
                flash('contact_success', 'Your message has been sent successfully!');
                header('Location: ' . URLROOT . '/HomeController/contact');
            } else {
                die('Something went wrong. Please try again later.');
            }
        }
        $this->view('LandingPage/contact');
    }
}
?>