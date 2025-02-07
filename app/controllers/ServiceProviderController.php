<?php
class ServiceProviderController extends Controller {
    
    public function index(){
        $this->view('ServiceProvider/appointments');
    }

    public function profile(){
        $this->view('ServiceProvider/profile');
    }
}