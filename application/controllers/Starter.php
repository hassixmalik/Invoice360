<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Starter extends CI_Controller {
	public function __construct()
	{
	  parent::__construct();
	  $this->load->model('Users');
	}
	public function index()
	{
		$data['customers'] = $this->Users->get_customers_with_unique_id();
		$this->template->page_title('Home | NMR')->load('starter', $data);
	}
}
