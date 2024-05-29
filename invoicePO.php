<?php
// Retrieve parameters from URL
$ProdOrder = $_GET["ProdOrder"];
$OrderType = $_GET["OrderType"];
$PurcOrder = $_GET["PurcOrder"];
$UOM = $_GET["UOM"];
$IssueDate = $_GET["IssueDate"];
$CompletionDate = $_GET["CompletionDate"];
$ItemCode = $_GET["ItemCode"];
$PackingType = $_GET["PackingType"];
$Description = $_GET["Description"];
$Quantity = $_GET["Quantity"];

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
        <p><strong>Production Order NO:</strong> <?php echo $ProdOrder; ?></p>
        <p><strong>Order Type:</strong> <?php echo $OrderType; ?></p>
        <p><strong>Purchase Order NO:</strong> <?php echo $PurcOrder; ?></p>
        <p><strong>Unit of Measure:</strong> <?php echo $UOM; ?></p>
        <p><strong>Issue Date:</strong> <?php echo $IssueDate; ?></p>
        <p><strong>Estimated Completion Date:</strong> <?php echo $CompletionDate; ?></p>
        <p><strong>Item Code:</strong> <?php echo $ItemCode; ?></p>
        <p><strong>Packing Type:</strong> <?php echo $PackingType; ?></p>
        <p><strong>Item Description:</strong> <?php echo $Description; ?></p>
        <p><strong>Total Quantity:</strong> <?php echo $Quantity; ?></p>
    </div>
</body>
</html>
