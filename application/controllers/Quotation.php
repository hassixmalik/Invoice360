<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends CI_Controller {
	public function __construct()
	{
	  parent::__construct();
	  $this->load->model('');
	}
    public function index(){
        $this->template->page_title('Quotations')->load('quotation');
    }

    public function quotationspage(){
        $this->template->page_title('Quotations')->load('quotationspage');
    }
}