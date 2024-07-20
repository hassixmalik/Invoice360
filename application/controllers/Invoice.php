<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {
	public function __construct()
	{
	  parent::__construct();
	  $this->load->model('Invoice_model');
	  $this->load->model('Users');
	  $this->load->library('session');
	}

    public function invoicespage(){
        $data['invoices'] = $this->Invoice_model->get_invoices();
        $this->template->page_title('Invoices')->load('invoicepage', $data);
    }

    public function addinvoice(){
		$data['customers'] = $this->Users->get_customers();
		$data['quote_numbers'] = $this->Invoice_model->get_quote_numbers();
		
        $data['invoice_details'] = [
            [
                'customer_unique_id' => '',
                'invoice No' => '',
                'Reference No' => '',
                'invoice Date' => '',
                'Expiry Date' => '',
                'Salesperson' => '',
                'Project Name' => '',
                'Subject' => '',
                'Services Description' => '',
                'Area' => '',
                'Qty' => '',
                'Price' => '',
                'Amt (BHD)' => ''
            ]
        ];
        $this->template->page_title('Invoices')->load('addinvoice', $data);
    }

	public function save_invoice() {
        // Prepare invoice data
        $data = array(
            'customer_unique_id' => $this->input->post('customer_name'),
            'invoice_no' => $this->input->post('invoice_no'),
            'order_no' => $this->input->post('reference_no'),
            //'invoice_date' => $this->input->post('invoice_date'),
            'expiry_date' => $this->input->post('expiry_date'),
            'salesperson' => $this->input->post('salesperson'),
            'project_name' => $this->input->post('project_name'),
            'subject' => $this->input->post('subject'),
            //'terms' => $this->input->post('terms'),
            //'payment_due' => $this->input->post('payment_due'), // Assuming payment_due is posted from form
            'status' => 'Draft' // Default status
        );

        // Prepare item data
        $items = array();
        $service_descriptions = $this->input->post('service_description');
        $areas = $this->input->post('area');
        $qtys = $this->input->post('qty');
        $prices = $this->input->post('price');
        $amts = $this->input->post('amt');

        for ($i = 0; $i < count($service_descriptions); $i++) {
            $items[] = array(
                'service_description' => $service_descriptions[$i],
                'area' => $areas[$i],
                'qty' => $qtys[$i],
                'price' => $prices[$i],
                'amt' => $amts[$i]
            );
        }

        // Save invoice and items
        $invoice_id = $this->Invoice_model->save_invoice($data, $items);

		// Prepare terms data
		$terms_data = array(
			'invoice_id' => $invoice_id,
			'terms' => $this->input->post('terms')
		);

		// Save terms and conditions
		$this->Invoice_model->save_invoice_terms($terms_data);

        if ($invoice_id) {
            redirect('invoice/addinvoice');
        } else {
            $this->session->set_flashdata('error', 'Failed to save invoice.');
        }

        
    }
}