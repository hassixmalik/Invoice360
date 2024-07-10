<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index()
	{
            $data['error_message']=FALSE;
		$this->template
            ->page_type('blank')
            ->page_title('Login page')
            ->tag_class('body', 'hold-transition login-page')
            ->load('login',$data);
	}

      public function authenticate(){

            $email = $this->input->post('username');
            $password = $this->input->post('password');

            if($email=='nmr' && $password=='786'){
                  $this->template->page_title('Dashboard')->load('starter');
            }
            else{
                  $data['error_message']=TRUE;
                  $this->template
                  ->page_type('blank')
                  ->page_title('Login page')
                  ->tag_class('body', 'hold-transition login-page')
                  ->load('login', $data);
            }
      }
}
