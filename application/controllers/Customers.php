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

	public function savecustomerform() {
		// Load the model
		$this->load->model('Users');
	
		// Get form data
		$customer_type = $this->input->post('customer_type');
		$customer_name = $this->input->post('customer_name');
		$company_name = $this->input->post('company_name');
		$customer_display_name = $this->input->post('customer_display_name');
		$customer_email = $this->input->post('customer_email');
		$customer_phone = $this->input->post('customer_phone');
		$currency = $this->input->post('currency');
		$opening_balance = $this->input->post('opening_balance');
		$payment_terms = $this->input->post('payment_terms');
		$documents = $this->input->post('documents');
		$billing_attention = $this->input->post('billing_attention');
		$billing_country_region = $this->input->post('billing_country_region');
		$billing_address = $this->input->post('billing_address');
		$billing_city = $this->input->post('billing_city');
		$billing_state = $this->input->post('billing_state');
		$billing_zipcode = $this->input->post('billing_zipcode');
		$billing_phone = $this->input->post('billing_phone');
		$billing_fax = $this->input->post('billing_fax');
		$shipping_attention = $this->input->post('shipping_attention');
		$shipping_country_region = $this->input->post('shipping_country_region');
		$shipping_address = $this->input->post('shipping_address');
		$shipping_city = $this->input->post('shipping_city');
		$shipping_state = $this->input->post('shipping_state');
		$shipping_zipcode = $this->input->post('shipping_zipcode');
		$shipping_phone = $this->input->post('shipping_phone');
		$shipping_fax = $this->input->post('shipping_fax');
	
		// Insert into new_customer table
		$customer_data = array(
			'customer_type' => $customer_type,
			'customer_name' => $customer_name,
			'company_name' => $company_name,
			'customer_display_name' => $customer_display_name,
			'customer_email' => $customer_email,
			'customer_phone' => $customer_phone
		);
		$customer_unique_id = $this->Users->insert_customer($customer_data);
	
		// Insert into other_details_of_customer table
		$other_details_data = array(
			'customer_unique_id' => $customer_unique_id,
			'currency' => $currency,
			'opening_balance' => $opening_balance,
			'payment_terms' => $payment_terms,
			'documents' => $documents
		);
		$this->Users->insert_other_details($other_details_data);
	
		// Insert into billing_address table
		$billing_data = array(
			'customer_unique_id' => $customer_unique_id,
			'attention' => $billing_attention,
			'country_region' => $billing_country_region,
			'address' => $billing_address,
			'city' => $billing_city,
			'state' => $billing_state,
			'zipcode' => $billing_zipcode,
			'phone' => $billing_phone,
			'fax_number' => $billing_fax
		);
		$this->Users->insert_billing_address($billing_data);
	
		// Insert into shipping_address table
		$shipping_data = array(
			'customer_unique_id' => $customer_unique_id,
			'attention' => $shipping_attention,
			'country_region' => $shipping_country_region,
			'address' => $shipping_address,
			'city' => $shipping_city,
			'state' => $shipping_state,
			'zipcode' => $shipping_zipcode,
			'phone' => $shipping_phone,
			'fax_number' => $shipping_fax
		);
		$this->Users->insert_shipping_address($shipping_data);
	
		// Redirect or load view after successful insertion
		redirect('customers/index'); // Adjust the redirect as needed
	}
	
}
