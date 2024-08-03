<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <a class='btn btn-failure' href="deletecustomer">Delete Customer</a>
        <form action="<?php echo base_url('customers/updatecustomer'); ?>" method="post">
            <input type="hidden" name="customer_unique_id" value="<?php echo $customer['customer_unique_id']; ?>">
            
            <!-- Customer details -->
            <div class="form-group">
                <label class="form-label">Customer Type</label>
                <input type="text" name="customer_type" value="<?php echo $customer['customer_type']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Customer Name</label>
                <input type="text" name="customer_name" value="<?php echo $customer['customer_name']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" value="<?php echo $customer['company_name']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Customer Display Name</label>
                <input type="text" name="customer_display_name" value="<?php echo $customer['customer_display_name']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Customer Email</label>
                <input type="email" name="customer_email" value="<?php echo $customer['customer_email']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Customer Phone</label>
                <input type="text" name="customer_phone" value="<?php echo $customer['customer_phone']; ?>" class="form-control">
            </div>
            
            <!-- Other details
            <div class="form-group">
                <label class="form-label">Currency</label>
                <input type="text" name="currency" value="//$other_details['currency'];" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Opening Balance</label>
                <input type="text" name="opening_balance" value="//$other_details['opening_balance'];" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Payment Terms</label>
                <input type="text" name="payment_terms" value="//$other_details['payment_terms'];" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Documents</label>
                <input type="text" name="documents" value="//$other_details['documents']; " class="form-control">
            </div> -->
            
            <!-- Billing address -->
            <div class="form-group">
                <label class="form-label">Attention</label>
                <input type="text" name="billing_attention" value="<?php echo $billing_address['attention']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Country/Region</label>
                <input type="text" name="billing_country_region" value="<?php echo $billing_address['country_region']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Address</label>
                <input type="text" name="billing_address" value="<?php echo $billing_address['address']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">City</label>
                <input type="text" name="billing_city" value="<?php echo $billing_address['city']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">State</label>
                <input type="text" name="billing_state" value="<?php echo $billing_address['state']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Zipcode</label>
                <input type="text" name="billing_zipcode" value="<?php echo $billing_address['zipcode']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="text" name="billing_phone" value="<?php echo $billing_address['phone']; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Fax</label>
                <input type="text" name="billing_fax" value="<?php echo $billing_address['fax_number']; ?>" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update Customer</button>
        </form>
    </div>
</body>
</html>
