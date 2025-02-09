<?php
Class CustomerController extends Controller {

    public function index(){
        $this->view('LandingPage/index');
    }

    public function services(){
        $this->view('LandingPage/services');
    }

    public function about(){
        $this->view('LandingPage/about');
    }

    public function contact(){
        $this->view('LandingPage/contact');
    }
   
}
?>