
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
    }

    .text-right {
        text-align: right;
    }

    .bold {
        font-weight: bold;
    }

    .container {
        width: 80%;
        margin: auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h1, h2, h3, p {
        margin: 0;
    }

    h1 {
        margin-bottom: 10px;
    }

    .table-bordered {
        border: 1px solid #ddd;
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    .table-bordered th, .table-bordered td {
        border: 1px solid #ddd;
        padding: 5px;
        text-align: center;
    }

    .table-bordered th {
        background-color: #f4f4f4;
    }

    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .invoice-header .company-details {
        text-align: left;
    }

    .invoice-header .invoice-details {
        text-align: right;
    }

    .company-details p, .invoice-details p {
        margin: 5px 0;
    }

    .myfooter {
        margin-top: 30px;
        text-align: center;
        font-size: 0.9em;
        color: #777;
        border-top: 1px solid #ddd;
        padding-top: 10px;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    @page {
        size: A4;
        margin: 20mm;
    }

    .contains {
        width: 210mm;
        height: 297mm;
        margin: 0 auto;
        padding: 10mm;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
        font-size: 10px;
        position: relative;
    }

    .container {
        width: 100%;
        height: 100%;
        padding: 5mm;
        box-sizing: border-box;
        background-color: #fff;
        position: relative;
    }

    .fixed-footer-content {
        position: absolute;
        bottom: 50px;
        width: 90%;
    }

        .button-row {
        text-align: center;
        border-radius: 5px;
    }
    .button-row button, .button-row .dropdown {
        margin: 5px;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        color: #fff;
        font-size: 14px;
    }
    .btn-edit {
        background-color: #6c757d;
    }
    .btn-send-mail {
        background-color: #007bff;
    }
    .btn-convert {
        background-color: #17a2b8;
    }
    .dropdown {
        display: inline-block;
        position: relative;
    }
    .dropdown-toggle {
        background-color: #28a745;
    }
    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #28a745;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        z-index: 1;
    }
    .dropdown:hover .dropdown-menu {
        display: block;
    }
    .dropdown-menu a {
        display: block;
        padding: 8px 15px;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
    }
    .dropdown-menu a:hover {
        background-color: #218838;
    }
    .signature-img {
        width: 130px;
        
    }
    </style>

<body>
<div class="button-row">
    <a class="btn-edit btn btn-primary" href='<?php echo base_url('editquotation/' . $quotation_no); ?>'><i class="fas fa-edit"></i> Edit</a>
    <button class="btn-send-mail"><i class="fas fa-envelope"></i> Send Mail</button>
    <div class="dropdown">
        <button class="dropdown-toggle"><i class="fas fa-file-alt"></i> PDF/Print</button>
        <div class="dropdown-menu">
            <a href="#"><i class="fas fa-file-pdf"></i> PDF</a>
            <a  id="printBtn"><i class="fas fa-print"></i> Print</a>
        </div>
    </div>
    <a class="btn-convert btn btn-secondary" href='<?php echo base_url('convert/' . $quotation_no); ?>'><i class="fas fa-exchange-alt"></i> Convert to Invoice</a>
</div>
<div class="contains" id='contentToPrint'>
    <div class="container">
    <p><img class="signature-img" src="<?php echo base_url('assets/dist/img/nmrlogo.jpg'); ?>" style='width:130px;' alt=""></p>
        <div class="invoice-header">
            <div class="company-details">
                <p><strong>Naeem Machine Repairing CO W.L.L</strong></p>
                <p>Kingdom of Bahrain</p>
                <p><a href="mailto:naeem.machinerepairing@gmail.com">naeem.machinerepairing@gmail.com</a></p>
            </div>
            <div class="invoice-details">
                <h1 style='color:blue'>QUOTE</h1>
                <p><span id="quote-number">#<?= $quotation_no ?></span></p>
                <p class="bold">Balance Due: <span id="balance-due">BHD 20</span></p>
            </div>
        </div>

        <table style='width:100%'>
            <tbody>
                <tr>
                    <td style="width: 50%;">
                        <p>Bill To</p>
                        <p class="bold"><span id="customer-name"><?= $quotation_details[0]['Name'] ?></span></p>
                        <p><span id="customer-address"><?= $quotation_details[0]['Address'] ?></span></p>
                        <p><span id="customer-city"><?= $quotation_details[0]['City'] ?></span></p>
                    </td>
                    <td style="width: 50%;" class="text-right">
                        <p>Date: <span id="invoice-date"><?= $quotation_details[0]['Date'] ?></span></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>Subject: <span id="invoice-subject"><?= $quotation_details[0]['Subject'] ?></span></p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <!-- <th>Services</th> -->
                    <th>Work Description</th>
                    <th>Area</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Amt. (BD)</th>
                </tr>
            </thead>
            <tbody id="invoice-items">
                <?php foreach($quotation_details as $index => $item): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $item['Work description'] ?></td>
                        <td><?= $item['Area'] ?></td>
                        <td><?= $item['Quantity'] ?></td>
                        <td><?= $item['Price'] ?></td>
                        <td><?= $item['Amount'] ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" class="text-right bold">Total Receivable</td>
                    <td><span id="total-receivable"><?= $quotation_details[0]['Subtotal'] ?></span></td>
                </tr>
            </tbody>
        </table>

        <div class="fixed-footer-content">
            <table style="width:100%">
                <tbody>
                    <tr>
                        <td style="width:50%">
                            <p>
                                <b>Terms and Conditions:</b>
                                <p>
                                    <ul>
                                        <li>70 % advance prior to work after approval</li>
                                        <li>30% upon completion of work Cheque</li>
                                        <li>Amount to be paid as Cheque / Bank Transfer</li>
                                        <li>Quotation to be valid for 15 days from the date of Quotation</li>
                                        <li>Quotation is subject to change upon verification of actual site requirements</li>
                                    </ul>
                                </p>
                            </p>
                        </td>
                        <td style="width:50%">
                            <p class="text-right">
                                Bank Details:<br>
                                IBAN: BH69BBKU00200006739065<br>
                                Cheque's Name: Naeem Machine
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p><b>
            Thanks for Trusting in Naeem Machine Repairing Co.
            For Naeem Machine Repairing Co W.L.L
            </b></p>
            <p style='text-align: end;'><img class="signature-img" src="<?php echo base_url('assets/dist/img/signature.jpg'); ?>" style='width:130px;' alt=""></p>
        </div>
        
        <footer class='myfooter fixed-footer-content'>
            C.R No: 132138-1 Building 2596B, Road 4450, Block 744, Al Ramli Kingdom of Bahrain<br>
            Email: <a href="mailto:naeem.machinerepairing@gmail.com">naeem.machinerepairing@gmail.com</a> , Mob No: +973 35952200
        </footer>
    </div>
</div>

</body>
<!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->
<script>
document.getElementById('printBtn').addEventListener('click', function () {
    var content = document.getElementById('contentToPrint').innerHTML;
    var printWindow = window.open('', '', 'height=842,width=595'); // A4 size in pixels

    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('<style>');
    printWindow.document.write(`
        /* Include your in-page CSS here */
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    font-size:12px;
}

.text-right {
    text-align: right;
}

.bold {
    font-weight: bold;
}


h1, h2, h3, p {
    margin: 0;
}

h1 {
    margin-bottom: 10px;
}

.table-bordered {
    border: 1px solid #ddd;
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
    font-size:12px;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #ddd;
    padding: 5px;
    text-align: center;
    font-size:12px;
}

.table-bordered th {
    background-color: #f4f4f4;
    font-size:12px;
}

.invoice-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.invoice-header .company-details {
    text-align: left;
}

.invoice-header .invoice-details {
    text-align: right;
}

.company-details p, .invoice-details p {
    margin: 5px 0;
}

.myfooter {
    margin-top: 30px;
    text-align: center;
    font-size: 0.9em;
    color: #777;
    border-top: 1px solid #ddd;
    padding-top: 10px;
}

.text-right {
    text-align: right;
}

.text-center {
    text-align: center;
}

@page {
    size: A4;
    margin: 20mm;
}

.contains {
    width: 210mm;
    height: 297mm;
    margin: 0 auto;
    padding: 10mm;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
    font-size: 10px;
    position: relative;
}

.container {
    width: 100%;
    height: 100%;
    padding: 5mm;
    box-sizing: border-box;
    background-color: #fff;
    position: relative;
}

.fixed-footer-content {
    position: absolute;
    bottom: 50px;
    width: 90%;
}

        .signature-img {
            width: 130px;
            
        }
    `);
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(content);
    printWindow.document.write('</body></html>');
    
    printWindow.document.close();
    printWindow.print();
});
</script>

