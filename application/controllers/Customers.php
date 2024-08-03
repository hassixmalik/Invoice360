<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
	public function __construct()
	{
	  parent::__construct();
	  $this->load->model('Users');
	}
  
	public function index()
	{
        $data['customers'] = $this->Users->get_all_customers();
		$this->template->page_title('Contacts | NMR')->load('customers', $data);
	}

    public function addcustomer(){
        $this->template->page_title('New Customer')->load('addcustomer');
    }

	public function savecustomerform() {
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
	

	////////////////////////
	//edit customer methods:
	////////////////////////
	public function editcustomer($customer_unique_id) {
		// Load customer data
		$data['customer'] = $this->Users->get_customer_by_id($customer_unique_id);
		$data['other_details'] = $this->Users->get_other_details_by_id($customer_unique_id);
		$data['billing_address'] = $this->Users->get_billing_address_by_id($customer_unique_id);
		//$data['shipping_address'] = $this->Users->get_shipping_address_by_id($customer_unique_id);
		
		// Check and replace null values in billing address
		if (!empty($data['billing_address'])) {
			foreach ($data['billing_address'] as $key => $value) {
				if (is_null($value)) {
					// Replace null with 0 for numeric fields or with '' for other fields
					$data['billing_address'][$key] = is_numeric($value) ? 0 : '';
				}
			}
		}
		
		// Load edit customer view with data
		$this->template->page_title('Edit Customer')->load('editcustomer', $data);
	}	

	public function updatecustomer() {
		// Get form data
		$customer_unique_id = $this->input->post('customer_unique_id');
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
	
		// Update customer data in new_customer table
		$customer_data = array(
			'customer_type' => $customer_type,
			'customer_name' => $customer_name,
			'company_name' => $company_name,
			'customer_display_name' => $customer_display_name,
			'customer_email' => $customer_email,
			'customer_phone' => $customer_phone
		);
		$this->Users->update_customer($customer_unique_id, $customer_data);
	
		// Update other details in other_details_of_customer table
		$other_details_data = array(
			'currency' => $currency,
			'opening_balance' => $opening_balance,
			'payment_terms' => $payment_terms,
			'documents' => $documents
		);
		$this->Users->update_other_details($customer_unique_id, $other_details_data);
	
		// Update billing address
		$billing_data = array(
			'attention' => $billing_attention,
			'country_region' => $billing_country_region,
			'address' => $billing_address,
			'city' => $billing_city,
			'state' => $billing_state,
			'zipcode' => $billing_zipcode,
			'phone' => $billing_phone,
			'fax_number' => $billing_fax
		);
		$this->Users->update_billing_address($customer_unique_id, $billing_data);
	
		// Update shipping address
		$shipping_data = array(
			'attention' => $shipping_attention,
			'country_region' => $shipping_country_region,
			'address' => $shipping_address,
			'city' => $shipping_city,
			'state' => $shipping_state,
			'zipcode' => $shipping_zipcode,
			'phone' => $shipping_phone,
			'fax_number' => $shipping_fax
		);
		$this->Users->update_shipping_address($customer_unique_id, $shipping_data);
	
		// Redirect to customers list page
		redirect('customers/index'); // Adjust the redirect as needed
	}
	
}
