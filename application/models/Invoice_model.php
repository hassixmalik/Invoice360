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

    public function get_invoice_details($invoice_no) {
        $this->db->select('
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
        $this->db->from('invoices q');
        $this->db->join('new_customer nc', 'q.customer_unique_id = nc.customer_unique_id');
        $this->db->join('billing_address ba', 'nc.customer_unique_id = ba.customer_unique_id');
        $this->db->join('items i', 'q.invoice_id = i.invoice_id');
        $this->db->join('due_payments dp', 'q.invoice_id = dp.invoice_id', 'left');
        $this->db->where('q.invoice_no', $invoice_no);

        $query = $this->db->get();
        return $query->result_array();
    }



    public function get_invoice_form_data($invoice_no) {
        $this->db->select('
            nc.customer_name AS `Customer Name`,
            q.invoice_no AS `invoice No`,
            q.order_no AS `Reference No`,
            q.invoice_date AS `Invoice Date`,
            q.expiry_date AS `Expiry Date`,
            q.salesperson AS `Salesperson`,
            q.project_name AS `Project Name`,
            q.subject AS `Subject`,
            i.service_description AS `Services Description`,
            i.area AS `Area`,
            i.qty AS `Qty`,
            i.price AS `Price`,
            i.amt AS `Amt (BHD)`
        ');
        $this->db->from('invoices q');
        $this->db->join('new_customer nc', 'q.customer_unique_id = nc.customer_unique_id');
        $this->db->join('billing_address ba', 'nc.customer_unique_id = ba.customer_unique_id', 'left');
        $this->db->join('items i', 'q.invoice_id = i.invoice_id');
        //$this->db->join('due_payments dp', 'q.invoice_id = dp.invoice_id', 'left');
        $this->db->where('q.invoice_no', $invoice_no);
    
        $query = $this->db->get();
        return $query->result_array();
    }
    

    public function invoice_exists($invoice_no) {
        $this->db->select('invoice_id');
        $this->db->from('invoices');
        $this->db->where('invoice_no', $invoice_no);
        $query = $this->db->get();
    
        return $query->num_rows() > 0;
    }

    public function update_invoice($invoice_no, $data, $items) {
        // Get the invoice_id using the invoice_no
        $this->db->select('invoice_id');
        $this->db->from('invoices');
        $this->db->where('invoice_no', $invoice_no);
        $query = $this->db->get();
        $result = $query->row();
        
        if (!$result) {
            return false; // Invoice not found
        }

        $invoice_id = $result->invoice_id;

        // Update the invoice table
        $this->db->where('invoice_no', $invoice_no);
        $this->db->update('invoices', $data);

        // Delete existing items for the invoice
        $this->db->where('invoice_id', $invoice_id);
        $this->db->delete('items');

        // Insert updated items
        foreach ($items as $item) {
            //unset($item['quotation_id']);
            $item['invoice_id'] = $invoice_id;
            $this->db->insert('items', $item);
        }

        return true;
    }


    public function delete_invoice_and_items($invoice_no) {
        // Start a transaction to ensure both deletions succeed
        $this->db->trans_start();
    
        // Get the invoice_id based on the invoice_no
        $this->db->select('invoice_id');
        $this->db->from('invoices');
        $this->db->where('invoice_no', $invoice_no);
        $invoice = $this->db->get()->row();
    
        if ($invoice) {
            $invoice_id = $invoice->invoice_id;
    
            // Delete items associated with the invoice
            $this->db->where('invoice_id', $invoice_id);
            $this->db->delete('items');
    
             // Delete payments associated with the invoice
            $this->db->where('invoice_id', $invoice_id);
            $this->db->delete('payments');

            // Delete due payments associated with the invoice
            $this->db->where('invoice_id', $invoice_id);
            $this->db->delete('due_payments');
            
            // Delete the invoice
            $this->db->where('invoice_no', $invoice_no);
            $this->db->delete('invoices');
        }
    
        // Complete the transaction
        $this->db->trans_complete();
    
        // Check if the transaction was successful
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    // Update the status of an invoice to 'Invoiced'
    public function update_invoice_status($invoice_no) {
        $this->db->set('status', 'Invoiced');
        $this->db->where('invoice_no', $invoice_no);
        return $this->db->update('invoices');
    }
    
    // Update the status of a quotation to 'Invoiced'
    public function update_quotation_status($quotation_no) {
        $this->db->set('status', 'Invoiced');
        $this->db->where('quotation_no', $quotation_no);
        return $this->db->update('quotations');
    }

}