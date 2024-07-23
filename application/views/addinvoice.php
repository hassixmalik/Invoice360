<!DOCTYPE html>
<html>
<head>
    <title>invoice Form</title>
    <style>
        .container {
            max-width: 800px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #6e82b7;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
        .btn-light {
            background-color: #f8f9fa;
            color: #333;
        }
        .btn-light:hover {
            background-color: #e2e6ea;
            color: white;
        }
        .btn:hover {
            background-color: #0056b3;
            color: white;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
<div class="container">
    <form id="invoice-form" action="<?php echo base_url('invoice/save_invoice'); ?>" method="post">
        <h2>Customer Details</h2>
        <label for="customerName">Customer Name</label>
        <select id="customerName" name="customer_name" required>
            <?php foreach ($customers as $customer): ?>
                <option value="<?php echo $customer['customer_unique_id']; ?>"><?php echo $customer['customer_name']; ?></option>
            <?php endforeach; ?>
        </select>

        <h2>invoice Details</h2>
        <label for="invoiceNo">invoice No</label>
        <input type="text" id="invoiceNo" name="invoice_no" value="<?php echo $invoice_details[0]['invoice No']; ?>" required>

        <label for="referenceNo">Order No</label>
        <?php if (!empty($quotation_no)) { ?>
            <input type="text" id="referenceNo" name="reference_no" value="<?php echo $quotation_no; ?>" disabled>
        <?php }else { ?> 
            <select id="referenceNo" name="reference_no">
            <?php foreach ($quote_numbers as $quote): ?>
                <option value="<?php echo $quote['quotation_no']; ?>"><?php echo $quote['quotation_no']; ?></option>
            <?php endforeach; ?>
            <option value="">None</option>
            </select>
        <?php }?>


        <!-- <label for="invoiceDate">Invoice Date</label>
        <input type="date" id="invoiceDate" name="invoice_date" value="<?php //echo $invoice_details[0]['invoice Date']; ?>" required> -->

        <label for="expiryDate">Due Date</label>
        <input type="date" id="expiryDate" name="expiry_date" value="<?php echo $invoice_details[0]['Expiry Date']; ?>" required>

        <label for="salesperson">Salesperson</label>
        <input type="text" id="salesperson" name="salesperson" value="<?php echo $invoice_details[0]['Salesperson']; ?>">

        <label for="projectName">Project Name</label>
        <input type="text" id="projectName" name="project_name" value="<?php echo $invoice_details[0]['Project Name']; ?>">

        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject" value="<?php echo $invoice_details[0]['Subject']; ?>">

        <h2>Item Details</h2>
        <table id="itemTable">
            <thead style='background-color: #6eb7a694;'>
                <tr>
                    <th>Services Description</th>
                    <th>Area</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Amt (BHD)</th>
                </tr>
            </thead>
            <tbody style='background-color: #80808014;'>
                <?php foreach($invoice_details as $index => $item): ?>
                    <tr>
                        <td><textarea name="service_description[]"><?php echo $item['Services Description']; ?></textarea></td>
                        <td><input type="text" name="area[]" value="<?php echo $item['Area']; ?>"></td>
                        <td><input type="number" name="qty[]" value="<?php echo $item['Qty']; ?>" min="0" oninput="calculateAmt(this)"></td>
                        <td><input type="number" name="price[]" value="<?php echo $item['Price']; ?>" step="0.01" min="0" oninput="calculateAmt(this)"></td>
                        <td><input type="number" name="amt[]" value="<?php echo $item['Amt (BHD)']; ?>" step="0.01" min="0" readonly></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="button" class="btn btn-light" onclick="addRow()">Add New Row</button>

        <!-- <h2>Terms and Conditions</h2>
        <textarea id="terms" name="terms" rows="4" required value='hasdasdasdasdas'></textarea> -->

        <div class="text-right">
            <button type="submit" class="submit btn">Save</button>
        </div>
    </form>
</div>

<script>
    function addRow() {
        const table = document.getElementById('itemTable').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        
        newRow.innerHTML = `
            <td><textarea type="text" name="service_description[]"></textarea></td>
            <td><input type="text" name="area[]"></td>
            <td><input type="number" name="qty[]" min="0" oninput="calculateAmt(this)"></td>
            <td><input type="number" name="price[]" step="0.01" min="0" oninput="calculateAmt(this)"></td>
            <td><input type="number" name="amt[]" step="0.01" min="0" readonly></td>
        `;
    }

    function calculateAmt(element) {
        const row = element.closest('tr');
        const qty = row.querySelector('input[name="qty[]"]').value;
        const price = row.querySelector('input[name="price[]"]').value;
        const amt = row.querySelector('input[name="amt[]"]');
        amt.value = (qty * price).toFixed(2);
    }
</script>
</body>
</html>
