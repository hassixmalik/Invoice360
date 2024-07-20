<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ivvoice extends CI_Controller {
	public function __construct()
	{
	  parent::__construct();
	  $this->load->model('Invoice_model');
	  $this->load->model('Users');
	}
    public function index(){
        $this->load->view('invoicepage');
    }
}