<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation_model extends MY_Model {
    public function save_quotation($data) {
        $this->db->insert('quotations', $data);
        return $this->db->insert_id(); // Return the inserted quotation_id
    }

    public function save_items($data) {
        $this->db->insert_batch('items', $data);
    }

    public function save_terms($data) {
        $this->db->insert('terms_and_conditions', $data);
    }

    public function get_quotations() {
        $this->db->select('q.quote_date, q.quotation_no, q.reference_no, c.customer_name, i.sub_total as amount');
        $this->db->from('quotations q');
        $this->db->join('new_customer c', 'q.customer_unique_id = c.customer_unique_id');
        $this->db->join('items i', 'q.quotation_id = i.quotation_id');
        $this->db->group_by('q.quotation_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    
}