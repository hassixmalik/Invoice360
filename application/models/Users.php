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
  }