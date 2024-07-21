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
        $this->db->select('q.quote_date, q.quotation_no, q.reference_no, c.customer_name, q.status, i.sub_total as amount');
        $this->db->from('quotations q');
        $this->db->join('new_customer c', 'q.customer_unique_id = c.customer_unique_id');
        $this->db->join('items i', 'q.quotation_id = i.quotation_id');
        $this->db->group_by('q.quotation_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_quotation_details($quotation_no) {
        $this->db->select('
            q.quote_date AS `Date`,
            dp.due_date AS `Due date`,
            nc.customer_name AS `Name`,
            ba.address AS `Address`,
            ba.city AS `City`,
            q.subject AS `Subject`,
            i.service_description AS `Work description`,
            i.area AS `Area`,
            i.qty AS `Quantity`,
            i.price AS `Price`,
            i.amt AS `Amount`,
            i.sub_total AS `Subtotal`
        ');
        $this->db->from('quotations q');
        $this->db->join('new_customer nc', 'q.customer_unique_id = nc.customer_unique_id');
        $this->db->join('billing_address ba', 'nc.customer_unique_id = ba.customer_unique_id');
        $this->db->join('items i', 'q.quotation_id = i.quotation_id');
        $this->db->join('due_payments dp', 'q.quotation_id = dp.quotation_id', 'left');
        $this->db->where('q.quotation_no', $quotation_no);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_quotation_form_data($quotation_no) {
        $this->db->select('
            nc.customer_name AS `Customer Name`,
            q.quotation_no AS `Quotation No`,
            q.reference_no AS `Reference No`,
            q.quote_date AS `Quote Date`,
            dp.due_date AS `Expiry Date`,
            q.salesperson AS `Salesperson`,
            q.project_name AS `Project Name`,
            q.subject AS `Subject`,
            i.service_description AS `Services Description`,
            i.area AS `Area`,
            i.qty AS `Qty`,
            i.price AS `Price`,
            i.amt AS `Amt (BHD)`
        ');
        $this->db->from('quotations q');
        $this->db->join('new_customer nc', 'q.customer_unique_id = nc.customer_unique_id');
        $this->db->join('billing_address ba', 'nc.customer_unique_id = ba.customer_unique_id', 'left');
        $this->db->join('items i', 'q.quotation_id = i.quotation_id');
        $this->db->join('due_payments dp', 'q.quotation_id = dp.quotation_id', 'left');
        $this->db->where('q.quotation_no', $quotation_no);
    
        $query = $this->db->get();
        return $query->result_array();
    }
    

    public function update_quotation($quotation_no, $data, $items) {
        // Get the quotation_id using the quotation_no
        $this->db->select('quotation_id');
        $this->db->from('quotations');
        $this->db->where('quotation_no', $quotation_no);
        $query = $this->db->get();
        $result = $query->row();
        
        if (!$result) {
            return false; // Quotation not found
        }

        $quotation_id = $result->quotation_id;

        // Update the quotation table
        $this->db->where('quotation_no', $quotation_no);
        $this->db->update('quotations', $data);

        // Delete existing items for the quotation
        $this->db->where('quotation_id', $quotation_id);
        $this->db->delete('items');

        // Insert updated items
        foreach ($items as $item) {
            $item['quotation_id'] = $quotation_id;
            $this->db->insert('items', $item);
        }

        return true;
    }

    public function quotation_exists($quotation_no) {
        $this->db->where('quotation_no', $quotation_no);
        $query = $this->db->get('quotations');
        return $query->num_rows() > 0;
    }

    public function get_quotation_id_by_no($quotation_no) {
        $this->db->select('quotation_id');
        $this->db->from('quotations');
        $this->db->where('quotation_no', $quotation_no);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->row()->quotation_id;
        } else {
            return false; // Return false if no matching quotation is found
        }
    }
    
    
}