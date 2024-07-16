
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
            padding: 10px;
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
        footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.9em;
            color: #777;
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
            padding: 20mm;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size:10px;
        }

        .container {
            width: 100%;
            height: 100%;
            border: 1px solid #000;
            padding: 10mm;
            box-sizing: border-box;
            background-color: #fff;
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
    </style>
<body>

<div class="button-row">
    <button class="btn-edit"><i class="fas fa-edit"></i> Edit</button>
    <button class="btn-send-mail"><i class="fas fa-envelope"></i> Send Mail</button>
    <div class="dropdown">
        <button class="dropdown-toggle"><i class="fas fa-file-alt"></i> PDF/Print</button>
        <div class="dropdown-menu">
            <a href="#"><i class="fas fa-file-pdf"></i> PDF</a>
            <a href="#"><i class="fas fa-print"></i> Print</a>
        </div>
    </div>
    <button class="btn-convert"><i class="fas fa-exchange-alt"></i>Record Payment</button>
</div>
<div class="contains">
<div class="container">
    <div class="invoice-header">
        <div class="company-details">
            <p><strong>Naeem Machine Repairing CO W.L.L</strong></p>
            <p>Kingdom of Bahrain</p>
            <p><a href="mailto:naeem.machinerepairing@gmail.com">naeem.machinerepairing@gmail.com</a></p>
        </div>
        <div class="invoice-details">
            <h1>Invoice</h1>
            <p>Invoice Number: <span id="invoice-number">#145</span></p>
            <p>Balance Due</p>
            <p class="bold">Balance Due: <span id="balance-due">BHD75.00</span></p>
        </div>
    </div>

    <table style='width:100%'>
        <tbody>
            <tr>
                <td style="width: 50%;">
                    <p>Bill To</p>
                    <p class="bold"><span id="customer-name">Name in bold</span></p>
                    <p><span id="customer-address">Address</span></p>
                    <p><span id="customer-city">City</span></p>
                </td>
                <td style="width: 50%;" class="text-right">
                    <p>Invoice Date: <span id="invoice-date">Add date</span></p>
                    <p>Terms: <span id="terms">Custom</span></p>
                    <p>Due Date: <span id="due-date">Add due date</span></p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>Subject: <span id="invoice-subject">Add subject here</span></p>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Services</th>
                <th>Work Description</th>
                <th>Area</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Amt. (BD)</th>
            </tr>
        </thead>
        <tbody id="invoice-items">
            <tr>
                <td>1</td>
                <td>Service 1</td>
                <td>Work Description 1</td>
                <td>Area 1</td>
                <td>1</td>
                <td>10.00</td>
                <td>10.00</td>
            </tr>
            <!-- More rows can be added here dynamically -->
            <tr>
                <td colspan="6" class="text-right bold">Total Receivable</td>
                <td><span id="total-receivable">10.00</span></td>
            </tr>
        </tbody>
    </table>

    <p class="text-right">
        Bank Details:<br>
        IBAN: BH69BBKU00200006739065<br>
        Cheque's Name: Naeem Machine
    </p>

    <p>
        Appreciate your interest to do business with NMR.
    </p>
</div>

<footer>
    C.R No: 132138-1 Building 2596B, Road 4450, Block 744, Al Ramli Kingdom of Bahrain<br>
    Email: <a href="mailto:naeem.machinerepairing@gmail.com">naeem.machinerepairing@gmail.com</a> , Mob No: +973 35952200, +97366686786
</footer>
</div>
</body>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

