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
        $this->template->page_title('Quotation')->load('quotation');
    }

    public function quotationspage(){
        $data['quotations'] = $this->Quotation_model->get_quotations();
        $this->template->page_title('All Quotations')->load('quotationspage', $data);
    }

    public function addquotation(){
        $data['customers'] = $this->Users->get_customers();
        $data['quotation_details'] = [
            [
                'customer_unique_id' => '',
                'Quotation No' => '',
                'Reference No' => '',
                'Quote Date' => '',
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
        $this->template->page_title('Save Quotations')->load('addquotation', $data);
    }

    // public function save_quotation() {
    //     $quotation_data = array(
    //         'customer_unique_id' => $this->input->post('customer_name'),
    //         'quotation_no' => $this->input->post('quotation_no'),
    //         'reference_no' => $this->input->post('reference_no'),
    //         'quote_date' => $this->input->post('quote_date'),
    //         'expiry_date' => $this->input->post('expiry_date'),
    //         'salesperson' => $this->input->post('salesperson'),
    //         'project_name' => $this->input->post('project_name'),
    //         'subject' => $this->input->post('subject')
    //     );
    
    //     $quotation_id = $this->Quotation_model->save_quotation($quotation_data);
    
    //     $item_data = array();
    //     $service_descriptions = $this->input->post('service_description');
    //     $areas = $this->input->post('area');
    //     $qtys = $this->input->post('qty');
    //     $prices = $this->input->post('price');
    //     $amts = $this->input->post('amt');
    //     $sub_total=0;
    //     //echo '<script>console.log("Service Descriptions: ' . json_encode($service_descriptions) . '");</script>';

    //     for ($i = 0; $i < count($service_descriptions); $i++) {
    //         $sub_total= $sub_total+$amts[$i];
    //     }

    //     for ($i = 0; $i < count($service_descriptions); $i++) {
    //         $item_data[] = array(
    //             'quotation_id' => $quotation_id,
    //             'service_description' => $service_descriptions[$i],
    //             'area' => $areas[$i],
    //             'qty' => $qtys[$i],
    //             'price' => $prices[$i],
    //             'amt' => $amts[$i],
    //             'sub_total'=>$sub_total
    //         );
    //     }
    
    //     $this->Quotation_model->save_items($item_data);
    
    //     $terms_data = array(
    //         'quotation_id' => $quotation_id,
    //         'terms' => $this->input->post('terms')
    //     );
    
    //     $this->Quotation_model->save_terms($terms_data);
    
    //     redirect('quotation/quotationspage'); // Redirect to success page or wherever you need
    // }




    public function save_quotation() {
        $quotation_no = $this->input->post('quotation_no');
        $is_update = $this->Quotation_model->quotation_exists($quotation_no);
    
        // Prepare quotation data
        $quotation_data = array(
            'customer_unique_id' => $this->input->post('customer_name'),
            'quotation_no' => $quotation_no,
            'reference_no' => $this->input->post('reference_no'),
            'quote_date' => $this->input->post('quote_date'),
            'expiry_date' => $this->input->post('expiry_date'),
            'salesperson' => $this->input->post('salesperson'),
            'project_name' => $this->input->post('project_name'),
            'subject' => $this->input->post('subject')
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
                'service_description' => $service_descriptions[$i],
                'area' => $areas[$i],
                'qty' => $qtys[$i],
                'price' => $prices[$i],
                'amt' => $amts[$i],
                'sub_total' => $sub_total
            );
        }
    
        if ($is_update) {
            // Update existing quotation
            $this->Quotation_model->update_quotation($quotation_no, $quotation_data, $items);
        } else {
            // Save new quotation and items
            $quotation_id = $this->Quotation_model->save_quotation($quotation_data);
    
            // Add quotation_id to each item
            foreach ($items as &$item) {
                $item['quotation_id'] = $quotation_id;
            }
    
            // Save items
            $this->Quotation_model->save_items($items);
    
            // Prepare terms data
            $terms_data = array(
                'quotation_id' => $quotation_id,
                'terms' => $this->input->post('terms')
            );
    
            // Save terms and conditions
            $this->Quotation_model->save_terms($terms_data);
        }
    
        redirect('quotation/quotationspage'); // Redirect to success page or wherever you need
    }

    
    public function viewquotation($quotation_no){
        $data['quotation_details'] = $this->Quotation_model->get_quotation_details($quotation_no);
        $data['quotation_no'] = $quotation_no;

        $this->template->page_title('Quotations')->load('quotation', $data);
    }

    public function editquotation($quotation_no){
        $data['quotation_details'] = $this->Quotation_model->get_quotation_form_data($quotation_no);
        $data['customers'] = $this->Users->get_customers();
        $this->template->page_title('Quotations')->load('addquotation', $data);
    }
    

    public function convert_to_invoice($quotation_no){
        $data['customers'] = $this->Users->get_customers();
        $data['invoice_details'] = $this->Quotation_model->get_quotation_form_data($quotation_no);
		$data['quotation_no'] = $quotation_no;
		
        $data['invoice_details'][0]['invoice No'] = '';
        $data['invoice_details'][0]['Reference No'] = '';

        $this->template->page_title('Convert to Invoice')->load('addinvoice', $data);
    }

    public function deletequotation($quotation_no){
        $result = $this->Quotation_model->delete_quotation_and_items($quotation_no);
    
        if($result) {
            // Successfully deleted
            redirect('quotation/quotationspage'); // Adjust this to your actual redirect page
        } else {
            // Deletion failed
            echo "Failed to delete the quotation.";
        }
    }
    
}