<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends CI_Controller {
	public function __construct()
	{
	  parent::__construct();
	  $this->load->model('Quotation_model');
	  $this->load->model('Users');
	}
    public function index(){
        $this->template->page_title('Quotations')->load('quotation');
    }

    public function quotationspage(){
        $data['quotations'] = $this->Quotation_model->get_quotations();
        $this->template->page_title('Quotations')->load('quotationspage', $data);
    }

    public function addquotation(){
        $data['customers'] = $this->Users->get_customers();
        $this->template->page_title('Quotations')->load('addquotation', $data);
    }

    public function save_quotation() {
        $quotation_data = array(
            'customer_unique_id' => $this->input->post('customer_name'),
            'quotation_no' => $this->input->post('quotation_no'),
            'reference_no' => $this->input->post('reference_no'),
            'quote_date' => $this->input->post('quote_date'),
            'expiry_date' => $this->input->post('expiry_date'),
            'salesperson' => $this->input->post('salesperson'),
            'project_name' => $this->input->post('project_name'),
            'subject' => $this->input->post('subject')
        );

        $quotation_id = $this->Quotation_model->save_quotation($quotation_data);

        $item_data = array();
        $service_descriptions = $this->input->post('service_description');
        $areas = $this->input->post('area');
        $qtys = $this->input->post('qty');
        $prices = $this->input->post('price');
        $amts = $this->input->post('amt');

        for ($i = 0; $i < count($service_descriptions); $i++) {
            $item_data[] = array(
                'quotation_id' => $quotation_id,
                'service_description' => $service_descriptions[$i],
                'area' => $areas[$i],
                'qty' => $qtys[$i],
                'price' => $prices[$i],
                'amt' => $amts[$i],
                'sub_total' => array_sum($amts)
            );
        }

        $this->Quotation_model->save_items($item_data);

        $terms_data = array(
            'quotation_id' => $quotation_id,
            'terms' => $this->input->post('terms')
        );

        $this->Quotation_model->save_terms($terms_data);

        redirect('quotation/quotationspage'); // Redirect to success page or wherever you need
    }
}