<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice_model extends MY_Model {
    
    public function get_invoices() {
        $this->db->select('q.invoice_date, q.invoice_no, q.order_no, c.customer_name, q.status, q.expiry_date, q.payment_due, i.sub_total as amount');
        $this->db->from('invoices q');
        $this->db->join('new_customer c', 'q.customer_unique_id = c.customer_unique_id');
        $this->db->join('items i', 'q.invoice_id = i.invoice_id');
        $this->db->group_by('q.invoice_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_quote_numbers() {
        $this->db->select('quotation_no');
        $this->db->from('quotations');
        $query = $this->db->get();
        return $query->result_array();
    }

    
    public function save_invoice($data, $items) {
        $this->db->insert('invoices', $data);
        $invoice_id = $this->db->insert_id();

        foreach ($items as $item) {
            $item['invoice_id'] = $invoice_id;
            $this->db->insert('items', $item);
        }
        
        return $invoice_id;
    }

    public function save_invoice_terms($terms_data) {
        $this->db->insert('terms_and_conditions', $terms_data);
    }
}