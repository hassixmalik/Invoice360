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
            q.expiry_date AS `Due date`,
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
        //$this->db->join('due_payments dp', 'q.invoice_id = dp.invoice_id', 'left');
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

    public function get_invoice_id_by_number($invoice_no) {
        // Using CodeIgniter's Query Builder class
        $this->db->select('invoice_id');
        $this->db->from('invoices');
        $this->db->where('invoice_no', $invoice_no);
        $query = $this->db->get();
        
        // Check if any record is returned
        if ($query->num_rows() > 0) {
            // Fetch the first row (which is the only row expected as invoice_no is unique)
            return $query->row()->invoice_id;
        } else {
            // No record found for the provided invoice_no
            return null;
        }
    }
    
    public function save_payment($data) {
        $invoice_id = $data['invoice_id'];
        $new_amount_received = $data['amount_received'];

        // Check if the invoice_id exists in the payments table
        $this->db->select('payment_id, amount_received');
        $this->db->from('payments');
        $this->db->where('invoice_id', $invoice_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Invoice ID exists, update the record
            $payment_id = $query->row()->payment_id;
            $existing_amount_received = $query->row()->amount_received;

            // Calculate the new total amount received
            $total_amount_received = $existing_amount_received + $new_amount_received;

            // Prepare data for updating
            $update_data = array(
                'amount_received' => $total_amount_received,
                'notes' => $data['notes'], // Update notes if needed
                // Other fields to update can be added here
            );

            // Update the existing record
            $this->db->where('payment_id', $payment_id);
            return $this->db->update('payments', $update_data);
        } else {
            // Invoice ID does not exist, insert new record
            return $this->db->insert('payments', $data);
        }
    }

    public function save_due_payment($data) {
        $invoice_id = $data['invoice_id'];

        // Check if the invoice_id exists in the due_payments table
        $this->db->select('due_payment_id');
        $this->db->from('due_payments');
        $this->db->where('invoice_id', $invoice_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Invoice ID exists, update the record
            $due_payment_id = $query->row()->due_payment_id;

            // Remove 'invoice_id' from data to prevent updating the primary key
            unset($data['invoice_id']);

            // Update the existing record
            $this->db->where('due_payment_id', $due_payment_id);
            return $this->db->update('due_payments', $data);
        } else {
            // Invoice ID does not exist, insert new record
            return $this->db->insert('due_payments', $data);
        }
    }
    


    public function get_amount_due_by_invoice_id($invoice_id) {
        $this->db->select('amount_due');
        $this->db->from('due_payments');
        $this->db->where('invoice_id', $invoice_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Invoice ID exists, return the amount_due
            return $query->row()->amount_due;
        } else {
            // Invoice ID does not exist, return NULL or any identifier
            return NULL;
        }
    }


    public function get_customer_invoices_details($customer_unique_id) {
        // Get invoice details
        $this->db->select('invoice_id, invoice_date, invoice_no, project_name');
        $this->db->from('invoices');
        $this->db->where('customer_unique_id', $customer_unique_id);
        $invoice_query = $this->db->get();
        $invoices = $invoice_query->result_array();

        // Get amount_due and amount_received for each invoice
        foreach ($invoices as &$invoice) {
            $invoice_id = $invoice['invoice_id'];

            // Get amount_due from due_payments
            $this->db->select('amount_due');
            $this->db->from('due_payments');
            $this->db->where('invoice_id', $invoice_id);
            $due_payment_query = $this->db->get();
            $due_payment = $due_payment_query->row_array();
            $invoice['amount_due'] = $due_payment ? $due_payment['amount_due'] : 0;

            // Get amount_received from payments
            $this->db->select('SUM(amount_received) as total_received');
            $this->db->from('payments');
            $this->db->where('invoice_id', $invoice_id);
            $payment_query = $this->db->get();
            $payment = $payment_query->row_array();
            $invoice['amount_received'] = $payment ? $payment['total_received'] : 0;
        }

        return $invoices;
    }

    public function get_customer_details($customer_unique_id) {
        // Select the required columns from the new_customer and billing_address tables
        $this->db->select('new_customer.customer_name, billing_address.address, billing_address.city');
        $this->db->from('new_customer');
        $this->db->join('billing_address', 'new_customer.customer_unique_id = billing_address.customer_unique_id', 'left');
        $this->db->where('new_customer.customer_unique_id', $customer_unique_id);

        // Execute the query and fetch the result
        $query = $this->db->get();
        return $query->row_array();
    }
}