<?php
class SignUpController extends Controller {
   

    public function customer() {
        $this->view('users/v_register_cu');
    }

    public function supplier() {
        $this->view('users/v_register_su');
    }

    public function provider() {
        $this->view('users/v_register_sp');
    }

}    