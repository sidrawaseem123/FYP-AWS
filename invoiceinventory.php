<?php
// Retrieve parameters from URL
$TotalQuantity = $_GET["TotalQuantity"];
$SupplierName = $_GET["SupplierName"];
$ItemName = $_GET["ItemName"];
$Quantity = $_GET["Quantity"];
$Price = $_GET["Price"];

// Generate the HTML invoice content
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .invoice {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #343a40;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #495057;
        }
        p strong {
            display: inline-block;
            width: 200px;
            color: #212529;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <h2>Invoice</h2>
        <p><strong>Total Quantity:</strong> <?php echo $TotalQuantity; ?></p>
        <p><strong>Supplier Name:</strong> <?php echo $SupplierName; ?></p>
        <p><strong>Color:</strong> <?php echo $ItemName; ?></p>
        <p><strong>Sub Quantity:</strong> <?php echo $Quantity; ?></p>
        <p><strong>Price:</strong> <?php echo $Price; ?></p>
       
    </div>
</body>
</html>
