<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {
	public function __construct()
	{
	  parent::__construct();
	  $this->load->model('Invoice_model');
	  $this->load->model('Quotation_model');
	  $this->load->model('Users');
	  $this->load->library('session');
	}
    public function index(){
        $data['invoices'] = $this->Invoice_model->get_invoices();
        $this->template->page_title('Invoices')->load('invoicepage', $data);
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

	// public function save_invoice() {
    //     // Prepare invoice data
    //     $data = array(
    //         'customer_unique_id' => $this->input->post('customer_name'),
    //         'invoice_no' => $this->input->post('invoice_no'),
    //         'order_no' => $this->input->post('reference_no'),
    //         'invoice_date' => date('Y-m-d'),
    //         'expiry_date' => $this->input->post('expiry_date'),
    //         'salesperson' => $this->input->post('salesperson'),
    //         'project_name' => $this->input->post('project_name'),
    //         'subject' => $this->input->post('subject'),
    //         //'terms' => $this->input->post('terms'),
    //         //'payment_due' => $this->input->post('payment_due'), // Assuming payment_due is posted from form
    //         'status' => 'Draft' // Default status
    //     );

    //     // Prepare item data
    //     $items = array();
    //     $service_descriptions = $this->input->post('service_description');
    //     $areas = $this->input->post('area');
    //     $qtys = $this->input->post('qty');
    //     $prices = $this->input->post('price');
    //     $amts = $this->input->post('amt');
    //     $sub_total=0;        

    //     //calculating total amount
    //     for ($i = 0; $i < count($service_descriptions); $i++) {
    //         $sub_total= $sub_total+$amts[$i];
    //     }

    //     for ($i = 0; $i < count($service_descriptions); $i++) {
    //         $items[] = array(
    //             'service_description' => $service_descriptions[$i],
    //             'area' => $areas[$i],
    //             'qty' => $qtys[$i],
    //             'price' => $prices[$i],
    //             'amt' => $amts[$i],
    //             'sub_total'=>$sub_total
    //         );
    //     }

    //     // Save invoice and items
    //     $invoice_id = $this->Invoice_model->save_invoice($data, $items);

	// 	// Prepare terms data
	// 	$terms_data = array(
	// 		'invoice_id' => $invoice_id,
	// 		'terms' => $this->input->post('terms')
	// 	);

	// 	// Save terms and conditions
	// 	$this->Invoice_model->save_invoice_terms($terms_data);

    //     if ($invoice_id) {
    //         redirect('invoice/invoicespage');
    //     } else {
    //         $this->session->set_flashdata('error', 'Failed to save invoice.');
    //     }
    // }

    public function viewinvoice($invoice_no){
        $data['invoice_details'] = $this->Invoice_model->get_invoice_details($invoice_no);
        $data['invoice_no'] = $invoice_no;
        $invoice_id=$this->Invoice_model->get_invoice_id_by_number($invoice_no);
        $data['amount_due']=$this->Invoice_model->get_amount_due_by_invoice_id($invoice_id);
        

        $this->template->page_title('Invoice')->load('invoice', $data);
    }


    public function editinvoice($invoice_no){
        $data['invoice_details'] = $this->Invoice_model->get_invoice_form_data($invoice_no);
        $data['customers'] = $this->Users->get_customers();
        $data['quote_numbers'] = $this->Invoice_model->get_quote_numbers();
        $this->template->page_title('Edit Invoice')->load('addinvoice', $data);
    }


    public function save_invoice() {
        $invoice_no = $this->input->post('invoice_no');
        $is_update = $this->Invoice_model->invoice_exists($invoice_no);
        $quotation_no=$this->input->post('reference_no');
        $quotation_id=$this->Quotation_model->get_quotation_id_by_no($quotation_no);
        $quotation_array = array_fill(0, 10, $quotation_id ? $quotation_id : NULL);

        //updating statuses into 'Invoiced'
        $this->Invoice_model->update_quotation_status($quotation_no);
        
        // Prepare invoice data
        $data = array(
            'customer_unique_id' => $this->input->post('customer_name'),
            'invoice_no' => $invoice_no,
            'order_no' => $this->input->post('reference_no'),
            'invoice_date' => date('Y-m-d'),
            'expiry_date' => $this->input->post('expiry_date'),
            'salesperson' => $this->input->post('salesperson'),
            'project_name' => $this->input->post('project_name'),
            'subject' => $this->input->post('subject'),
            'status' => 'Draft' // Default status
        );
    
        // Prepare item data
        $items = array();
        $service_descriptions = $this->input->post('service_description');
        $areas = $this->input->post('area');
        $qtys = $this->input->post('qty');
        $prices = $this->input->post('price');
        $amts = $this->input->post('amt');
        $sub_total = 0;
    
        // Calculating total amount
        for ($i = 0; $i < count($service_descriptions); $i++) {
            $sub_total = $sub_total + $amts[$i];
        }
    
        for ($i = 0; $i < count($service_descriptions); $i++) {
            $items[] = array(
                'quotation_id' => $quotation_array[$i],
                'service_description' => $service_descriptions[$i],
                'area' => $areas[$i],
                'qty' => $qtys[$i],
                'price' => $prices[$i],
                'amt' => $amts[$i],
                'sub_total' => $sub_total
            );
        }
    
        if ($is_update) {
            // Update existing invoice
            $this->Invoice_model->update_invoice($invoice_no, $data, $items);
            $this->Invoice_model->update_invoice_status($invoice_no);
            redirect('invoice/invoicespage');
        } else {
            // Save new invoice and items
            $invoice_id = $this->Invoice_model->save_invoice($data, $items);
            $this->Invoice_model->update_invoice_status($invoice_no);
            redirect('invoice/invoicespage');
        }
    }

    public function deleteinvoice($invoice_no){
        $result = $this->Invoice_model->delete_invoice_and_items($invoice_no);

        if ($result) {
            $data['success']='Invoice Deleted Successfully';
            $data['invoices'] = $this->Invoice_model->get_invoices();
            $this->template->page_title('Invoices')->load('invoicepage', $data);
        } else {
            redirect('errors\Custom404.php');
        }
    }
    public function save_payment() {
        $invoice_no=$this->input->post('invoice_no');
        $invoice_id= $this->Invoice_model->get_invoice_id_by_number($invoice_no);
        //i need to check if there exists any previous payments of invoice, if yes then it means i can
        //not subtract amount_recieved from sub_total, it will cause a never endinng loop of payment
        //which will keep payment to be there everytime
        $sub_total=$this->input->post('sub_total');
        $amount_received=$this->input->post('amount_received');
        $remaining_balance=$this->Invoice_model->get_amount_due_by_invoice_id($invoice_id);
        if($remaining_balance){
            $remaining_balance= $remaining_balance  -   $amount_received;
        }
        else{$remaining_balance= $sub_total  -   $amount_received;
        }

        if($remaining_balance>0){
            $data_remaining_balance = array(
                'due_date' =>  $this->input->post('due_date'),
                'amount_due' => $remaining_balance,
                'status' => 'Pending',
                'invoice_id' => $invoice_id
            );
            $this->Invoice_model->save_due_payment($data_remaining_balance);
        }
        
        $data = array(
            //'customer_name' => $this->input->post('customer_name'),
            'payment_id' => $this->input->post('payment_no'),
            'payment_date' =>  date('Y-m-d'),
            'amount_received' => $this->input->post('amount_received'),
            'notes' => $this->input->post('notes'),
            'invoice_id' => $invoice_id
        );
        error_log(print_r($data, true)); // This will log data to the server's error log
        $result = $this->Invoice_model->save_payment($data);
    
        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'Payment saved successfully. Refresh the Page to see Updated Info'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to save payment.'));
        }
    }
    
    public function viewstatment($customer_unique_id){
        $data['invoice_details'] = $this->Invoice_model->get_customer_invoices_details($customer_unique_id);
        $data['customer_details'] = $this->Invoice_model->get_customer_details($customer_unique_id);
        $data['customer_id'] = $customer_unique_id;
        $this->template->page_title('View Statment')->load('statment', $data);
    }
}