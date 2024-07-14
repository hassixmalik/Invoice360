
    <style>
        /* body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        } */
        .container {
            max-width: 800px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #6e82b7
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
            color:white;
        }
        .btn:hover {
            background-color: #0056b3;
            color:white;
        }
        .text-right {
            text-align: right;
        }
    </style>

<body>

<div class="container">
    <form id="quotation-form">
        <h2>Customer Details</h2>
        <label for="customerName">Customer Name</label>
        <select id="customerName" name="customer_name" required>
            <?php foreach ($customers as $customer): ?>
                <option value="<?php echo $customer['customer_unique_id']; ?>"><?php echo $customer['customer_name']; ?></option>
            <?php endforeach; ?>
        </select>


        <h2>Quotation Details</h2>
        <label for="quotationNo">Quotation No</label>
        <input type="text" id="quotationNo" name="quotation_no" required>

        <label for="referenceNo">Reference No</label>
        <input type="text" id="referenceNo" name="reference_no">

        <label for="quoteDate">Quote Date</label>
        <input type="date" id="quoteDate" name="quote_date" required>

        <label for="expiryDate">Expiry Date</label>
        <input type="date" id="expiryDate" name="expiry_date" required>

        <label for="salesperson">Salesperson</label>
        <input type="text" id="salesperson" name="salesperson">

        <label for="projectName">Project Name</label>
        <input type="text" id="projectName" name="project_name">

        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject">

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
                <tr>
                    <td><input type="text" name="service_description[]"></td>
                    <td><input type="text" name="area[]"></td>
                    <td><input type="number" name="qty[]" min="0"></td>
                    <td><input type="number" name="price[]" step="0.01" min="0"></td>
                    <td><input type="number" name="amt[]" step="0.01" min="0" readonly></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-light" onclick="addRow()">Add New Row</button>

        <h2>Terms and Conditions</h2>
        <textarea id="terms" name="terms" rows="4" required></textarea>

        <div class="text-right">
            <a type="submit" class="btn" href='<?php echo base_url('save_quotation') ?>'>Save</a>
        </div>
    </form>
</div>

<script>
    function addRow() {
        const table = document.getElementById('itemTable').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        
        newRow.innerHTML = `
            <td><input type="text" name="service_description[]"></td>
            <td><input type="text" name="area[]"></td>
            <td><input type="number" name="qty[]" min="0"></td>
            <td><input type="number" name="price[]" step="0.01" min="0"></td>
            <td><input type="number" name="amt[]" step="0.01" min="0" readonly></td>
        `;
    }
    
    document.getElementById('quotation-form').addEventListener('submit', function(event) {
        event.preventDefault();
        // Save the form data to the database
    });
</script>

</body>

