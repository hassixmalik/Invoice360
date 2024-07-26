<style>
  /* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 16px;
    text-align: left;
}

th, td {
    padding: 12px 15px;
    border: 1px solid #ddd;
}

thead th {
    background-color: #f4f4f4;
    color: #333;
    font-weight: bold;
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

tbody tr:hover {
    background-color: #f1f1f1;
}

table caption {
    caption-side: bottom;
    font-size: 14px;
    color: #777;
}

.no-records {
    text-align: center;
    font-style: italic;
    color: #777;
}

</style>
<div class="row">
  <div class="col-lg-6">
    <div class="card card-primary card-outline">
      <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
              <h3 class="card-title"><strong>Total Recievables</strong></h3>
              <div class="dropdown">
                  <a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-plus"></i> New
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="#">New Invoice</a>
                      <a class="dropdown-item" href="#">New Recurring Invoice</a>
                      <a class="dropdown-item" href="#">New Customer Payment</a>
                  </div>
              </div>
          </div>
          <p class="card-text">Total Unpaid Invoices: BHD0.000</p>
          <div class="d-flex justify-content-between align-items-center">
            <div class='col-sm-6'>
              <div class="row"><h3 class="card-title">Current</h3></div>
              <div class="row"><h4>BHD: <?= $total_revenue ?></h4></div>
            </div>
            <div class='col-sm-6'>
              <div class="row"><h3 class="card-title">Overdue</h3></div>
              <div class="row"><h4>BHD000</h4></div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<div class="row" style='margin-top:10px;'>
<h2>Get Statments:</h2>
<table style='border:1' cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Customer Name</th>
            <th>Company Name</th>
            <th>View Statment</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($customers)) : ?>
            <?php foreach ($customers as $customer) : ?>
                <tr>
                    <td><?php echo $customer['customer_name']; ?></td>
                    <td><?php echo $customer['company_name']; ?></td>
                    <td><a href="<?php echo base_url('viewstatment/' . $customer['customer_unique_id']); ?>"><i class="fas fa-eye"></i></a></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="4">No records found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>