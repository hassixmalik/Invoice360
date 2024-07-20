<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>invoices</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .dropdown-toggle::after {
            margin-left: 0.5em;
        }
        .search-icon-btn {
            background: none;
            border: none;
            cursor: pointer;
        }
        .search-icon-btn i {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="container mt-1">
            <div class="d-flex justify-content-end align-items-center mb-3">
                <div class="">
                    <a href="<?php echo base_url('addinvoice') ?>" class="btn btn-primary" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-plus"></i> New
                    </a>
                </div>
            </div>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Invoice Number</th>
                        <th>Order Number</th>
                        <th>Customer Name</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Amount</th>
                        <th>Balance Due</th>
                        <th>
                            <button class="search-icon-btn">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($invoices)): ?>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr>
                                <td><?php echo $invoice['invoice_date']; ?></td>
                                <td><?php echo $invoice['invoice_no']; ?></td>
                                <td><?php echo $invoice['order_no']; ?></td>
                                <td><?php echo $invoice['customer_name']; ?></td>
                                <td><?php echo $invoice['status']; ?></td>
                                <td><?php echo $invoice['expiry_date']; ?></td>
                                <td><?php echo $invoice['amount']; ?></td>
                                <td><?php echo $invoice['payment_due']; ?></td>
                                <td><a href="<?php echo base_url('viewinvoice/' . $invoice['invoice_no']); ?>"><i class="fas fa-eye"> &nbsp; view</i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No invoices found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
