<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Customers</title>
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .dropdown-toggle::after {
            margin-left: 0.5em;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1>All Customers</h1>
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
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?php echo $customer['customer_name']; ?></td>
                                <td><?php echo $customer['company_name']; ?></td>
                                <td><?php echo $customer['customer_email']; ?></td>
                                <td><?php echo $customer['customer_phone']; ?></td>
                                <td><?php echo $customer['recievables']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No customers found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
