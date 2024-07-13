<style>
        .table th, .table td {
            vertical-align: middle;
        }
        .dropdown-toggle::after {
            margin-left: 0.5em;
        }
</style>
<div class="row">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Quotations</h1>
        <div class="">
            <a href="<?php echo base_url('addcustomer') ?>" class="btn btn-primary" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-plus"></i> New
            </a>
        </div>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NAME</th>
                <th>COMPANY NAME</th>
                <th>EMAIL</th>
                <th>WORK PHONE</th>
                <th>RECEIVABLES (BCY)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example row -->
            <tr>
                <td>John Doe</td>
                <td>Example Corp</td>
                <td>john.doe@example.com</td>
                <td>(123) 456-7890</td>
                <td>BHD100.00</td>
            </tr>
            <!-- More rows go here -->
        </tbody>
    </table>
</div>
</div>