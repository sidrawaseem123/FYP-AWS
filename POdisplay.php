<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .actions {
            text-align: center;
            padding: 8px;
        }

        .delete-btn {
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #ff6666;
        }

        @media screen and (max-width: 600px) {
            th, td {
                padding: 8px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <?php
    include("connection.php");

    // Handle delete action
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $delete_query = "DELETE FROM purchordertable WHERE PurcOrder = '$delete_id'";
        mysqli_query($conn, $delete_query);
    }

    // Retrieve data from the database
    $query = "SELECT * FROM purchordertable INNER JOIN iteminfo ON purchordertable.PurcOrder=iteminfo.PurcOrder";
    $result = mysqli_query($conn, $query);
    echo "<h2>PURCHASE ORDER DATA</h2>";
    echo "<div style='overflow-x:auto;'>
            <table>
                <tr>
                    <th>Production Order NO</th>
                    <th>Order Type</th>
                    <th>Purchase Order NO</th>
                    <th>Unit of Measure</th>
                    <th>Issue Date</th>
                    <th>Estimated Completion Date</th>
                    <th>Item Code</th>
                    <th>Packing Type</th>
                    <th>Item Description</th>
                   
                    <th>Item ID</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Order Quantity</th>
                    <th class='actions'>Actions</th>
                </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['ProdOrder']}</td>
                <td>{$row['OrderType']}</td>
                <td>{$row['PurcOrder']}</td>
                <td>{$row['UOM']}</td>
                <td>{$row['IssueDate']}</td>
                <td>{$row['CompletionDate']}</td>
                <td>{$row['ItemCode']}</td>
                <td>{$row['PackingType']}</td>
                <td>{$row['Description']}</td>
              
                <td>{$row['id']}</td>
                <td>{$row['Color']}</td>
                <td>{$row['Size']}</td>
                <td>{$row['OrderQuantity']}</td>
                <td class='actions'>
                    <a href='?delete_id={$row['PurcOrder']}' class='delete-btn'>Delete</a>
                </td>
              </tr>";
    }

    echo "</table>
        </div>";

    mysqli_close($conn);
    ?>
</body>
</html>
