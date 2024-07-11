<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
	public function index()
	{
		$this->template->page_title('Contacts | NMR')->load('customers');
	}

    public function addcustomer(){
        $this->template->page_title('New Customer')->load('addcustomer');
    }
}
