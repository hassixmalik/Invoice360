<style>
        .form-section {
            margin-bottom: 20px;
        }
</style>


<div class="container mt-5">
    <h1>New Customer</h1>
    
    <form action="<?php echo base_url('savecustomerform'); ?>" method="post">
    <!-- Block 1: Priority Fields -->
    <div class="form-section">
        <div class="form-group">
            <label for="customerType">Customer Type</label>
            <select id="customerType"  name="customer_type" class="form-control" required>
                <option value="Business">Business</option>
                <option value="Individual">Individual</option>
            </select>
        </div>
        <div class="form-group">
            <label for="customerName">Customer Name</label>
            <input type="text" id="customerName" name="customer_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="companyName">Company Name</label>
            <input type="text" id="companyName" name="company_name" class="form-control">
        </div>
        <div class="form-group">
            <label for="customerDisplayName">Customer Display Name</label>
            <input type="text" id="customerDisplayName" name="customer_display_name" class="form-control">
        </div>
        <div class="form-group">
            <label for="customerEmail">Customer Email</label>
            <input type="email" id="customerEmail" name="customer_email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="customerPhone">Customer Phone</label>
            <input type="text" id="customerPhone" name="customer_phone" class="form-control">
        </div>
    </div>

    <!-- Navbar for Additional Details -->
    <ul class="nav nav-tabs" id="customerDetailsTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="other-details-tab" data-toggle="tab" href="#other-details" role="tab" aria-controls="other-details" aria-selected="true">Other Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="address-details-tab" data-toggle="tab" href="#address-details" role="tab" aria-controls="address-details" aria-selected="false">Address Details</a>
        </li>
    </ul>
    <div class="tab-content" id="customerDetailsTabContent">
        <!-- Other Details Tab -->
        <div class="tab-pane fade show active form-section" id="other-details" role="tabpanel" aria-labelledby="other-details-tab">
            <div class="form-group">
                <label for="currency">Currency</label>
                <input type="text" id="currency" name="currency" class="form-control">
            </div>
            <div class="form-group">
                <label for="openingBalance">Opening Balance</label>
                <input type="number" id="openingBalance" name="opening_balance" class="form-control">
            </div>
            <div class="form-group">
                <label for="paymentTerms">Payment Terms</label>
                <input type="text" id="paymentTerms" name="payment_terms" class="form-control">
            </div>
            <div class="form-group">
                <label for="documents">Documents</label>
                <textarea id="documents" name="documents" class="form-control"></textarea>
            </div>
        </div>

        <!-- Address Details Tab -->
        <div class="tab-pane fade form-section" id="address-details" role="tabpanel" aria-labelledby="address-details-tab">
            <h3>Billing Address</h3>
            <div class="form-group">
                <label for="billingAttention">Attention</label>
                <input type="text" id="billingAttention" name="billing_attention" class="form-control">
            </div>
            <div class="form-group">
                <label for="billingCountryRegion">Country/Region</label>
                <input type="text" id="billingCountryRegion" name="billing_country_region" class="form-control">
            </div>
            <div class="form-group">
                <label for="billingAddress">Address</label>
                <input type="text" id="billingAddress" name="billing_address" class="form-control">
            </div>
            <div class="form-group">
                <label for="billingCity">City</label>
                <input type="text" id="billingCity" name="billing_city" class="form-control">
            </div>
            <div class="form-group">
                <label for="billingState">State</label>
                <input type="text" id="billingState" name="billing_state" class="form-control">
            </div>
            <div class="form-group">
                <label for="billingZipcode">Zipcode</label>
                <input type="text" id="billingZipcode" name="billing_zipcode" class="form-control">
            </div>
            <div class="form-group">
                <label for="billingPhone">Phone</label>
                <input type="text" id="billingPhone" name="billing_phone" class="form-control">
            </div>
            <div class="form-group">
                <label for="billingFax">Fax Number</label>
                <input type="text" id="billingFax" name="billing_fax" class="form-control">
            </div>

            <h3>Shipping Address</h3>
            <div class="form-group">
                <label for="shippingAttention">Attention</label>
                <input type="text" id="shippingAttention" name="shipping_attention" class="form-control">
            </div>
            <div class="form-group">
                <label for="shippingCountryRegion">Country/Region</label>
                <input type="text" id="shippingCountryRegion" name="shipping_country_region" class="form-control">
            </div>
            <div class="form-group">
                <label for="shippingAddress">Address</label>
                <input type="text" id="shippingAddress" name="shipping_address" class="form-control">
            </div>
            <div class="form-group">
                <label for="shippingCity">City</label>
                <input type="text" id="shippingCity" name="shipping_city" class="form-control">
            </div>
            <div class="form-group">
                <label for="shippingState">State</label>
                <input type="text" id="shippingState" name="shipping_state" class="form-control">
            </div>
            <div class="form-group">
                <label for="shippingZipcode">Zipcode</label>
                <input type="text" id="shippingZipcode" name="shipping_zipcode" class="form-control">
            </div>
            <div class="form-group">
                <label for="shippingPhone">Phone</label>
                <input type="text" id="shippingPhone" name="shipping_phone" class="form-control">
            </div>
            <div class="form-group">
                <label for="shippingFax">Fax Number</label>
                <input type="text" id="shippingFax" name="shipping_fax" class="form-control">
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <button type="submit" class="btn btn-primary">Save</button>
</form>

</div>