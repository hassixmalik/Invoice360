<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotations</title>
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
                    <a href="<?php echo base_url('addquotation') ?>" class="btn btn-primary" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-plus"></i> New
                    </a>
                </div>
            </div>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Quote Number</th>
                        <th>Reference Number</th>
                        <th>Customer Name</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>
                            <button class="search-icon-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($quotations)): ?>
                        <?php foreach ($quotations as $quotation): ?>
                            <tr>
                                <td><?php echo $quotation['quote_date']; ?></td>
                                <td><?php echo $quotation['quotation_no']; ?></td>
                                <td><?php echo $quotation['reference_no']; ?></td>
                                <td><?php echo $quotation['customer_name']; ?></td>
                                <td style="background-color: <?php echo $quotation['status'] == 'Draft' ? '#d3d3d3' : ($quotation['status'] == 'Invoiced' ? '#add8e6' : ''); ?>;"><?php echo $quotation['status']; ?></td>
                                <td><?php echo $quotation['amount']; ?></td>
                                <td><a href="<?php echo base_url('viewquotation/' . $quotation['quotation_no']); ?>"><i class="fas fa-eye"></i></a></td>
                                <td><a href="<?php echo base_url('deletequotation/' . $quotation['quotation_no']); ?>"><i class="fas fa-trash-alt" style="color: red;"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No quotations found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
