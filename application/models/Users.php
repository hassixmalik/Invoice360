<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
  class Users extends MY_Model {
    public $table = "users";
    public $alias = "u";
    public $allowed_columns = [
      'id', 
      'fullname', 
      'username', 
      'password',
      'email', 
      'is_active'
    ];

    public function insert_customer($data) {
        $this->db->insert('new_customer', $data);
        return $this->db->insert_id();
    }

    public function insert_other_details($data) {
        $this->db->insert('other_details_of_customer', $data);
    }

    public function insert_billing_address($data) {
        $this->db->insert('billing_address', $data);
    }

    public function insert_shipping_address($data) {
        $this->db->insert('shipping_address', $data);
    }

    public function get_all_customers() {
      $this->db->select('nc.customer_name, nc.company_name, nc.customer_email, nc.customer_phone, nc.recievables, nc.customer_unique_id');
      $this->db->from('new_customer nc');
      $this->db->join('other_details_of_customer odc', 'odc.customer_unique_id = nc.customer_unique_id', 'left');
      $this->db->join('billing_address ba', 'ba.customer_unique_id = nc.customer_unique_id', 'left');
      $this->db->join('shipping_address sa', 'sa.customer_unique_id = nc.customer_unique_id', 'left');
      $query = $this->db->get();
      return $query->result_array();
    }

    public function get_customers() {
      $query = $this->db->get('new_customer');
      return $query->result_array();
    }

    public function get_customers_with_unique_id() {
      // Select the required fields from the 'new_customer' table
      $this->db->select('customer_unique_id, customer_name, company_name, recievables');
      $this->db->from('new_customer');
      
      // Execute the query
      $query = $this->db->get();
      
      // Check if there are results
      if ($query->num_rows() > 0) {
          // Return the results as an associative array
          return $query->result_array();
      } else {
          // Return an empty array if no records found
          return [];
      }
  }

  public function get_total_revenue()
  {
    // Initialize total revenue
    $total_revenue = 0;

    // Get all invoice_ids from the invoices table
    $this->db->select('invoice_id');
    $invoice_ids = $this->db->get('invoices')->result_array();

    // Loop through each invoice_id
    foreach ($invoice_ids as $invoice) {
        // Get the subtotal from items table for each invoice_id
        $this->db->select_sum('sub_total');
        $this->db->where('invoice_id', $invoice['invoice_id']);
        $sub_total_result = $this->db->get('items')->row_array();
        
        // Add the sub_total to total_revenue
        $total_revenue += isset($sub_total_result['sub_total']) ? $sub_total_result['sub_total'] : 0;
    }

    return $total_revenue;
  }

  
  
  //used for update methods
  public function get_customer_by_id($customer_unique_id) {
    $this->db->where('customer_unique_id', $customer_unique_id);
    $query = $this->db->get('new_customer');
    return $query->row_array();
  }

public function get_other_details_by_id($customer_unique_id) {
    $this->db->where('customer_unique_id', $customer_unique_id);
    $query = $this->db->get('other_details_of_customer');
    return $query->row_array();
  }

public function get_billing_address_by_id($customer_unique_id) {
    $this->db->where('customer_unique_id', $customer_unique_id);
    $query = $this->db->get('billing_address');
    return $query->row_array();
  }

public function get_shipping_address_by_id($customer_unique_id) {
    $this->db->where('customer_unique_id', $customer_unique_id);
    $query = $this->db->get('shipping_address');
    return $query->row_array();
  }

  public function update_customer($customer_unique_id, $data) {
    $this->db->where('customer_unique_id', $customer_unique_id);
    $this->db->update('new_customer', $data);
}

public function update_other_details($customer_unique_id, $data) {
    $this->db->where('customer_unique_id', $customer_unique_id);
    $this->db->update('other_details_of_customer', $data);
}

public function update_billing_address($customer_unique_id, $data) {
    $this->db->where('customer_unique_id', $customer_unique_id);
    $this->db->update('billing_address', $data);
}

public function update_shipping_address($customer_unique_id, $data) {
    $this->db->where('customer_unique_id', $customer_unique_id);
    $this->db->update('shipping_address', $data);
}



}