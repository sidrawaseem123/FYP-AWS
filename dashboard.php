<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        html {
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f7fafc;
        }

        #maindiv {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        #topdiv {
            background-color: #1a202c;
            padding: 20px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .top-buttons {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
        }

        .sidebar-button {
            padding: 10px 20px;
            margin-right: 20px;
            margin-bottom: 10px;
            color: #fff;
            background-color: #1a202c;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .sidebar-button:hover {
            background-color: #4a5568;
        }

        .sidebar-button:last-child {
            margin-right: 0;
        }

        #rightdiv {
            flex: 1;
            background-color: #edf2f7;
            padding: 20px;
            overflow: auto;
        }

        #heading {
            font-size: 28px;
            margin-bottom: 10px;
            color: #2d3748;
        }

        #heading h6 {
            font-size: 16px;
            color: #718096;
            margin-bottom: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .total-box {
            flex: 1;
            min-width: 200px;
            margin: 10px;
            background-color: #edf2f7;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s;
        }

        .total-box:hover {
            transform: translateY(-5px);
        }

        .dash-button {
            background-color: #2d3748;
            color: white;
            border: none;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .dash-button:hover {
            background-color: #4a5568;
        }

        .data-container {
            width: 100%;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .data-container h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #2d3748;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            height: 40px;
            text-align: center;
            border: 1px solid #cbd5e0;
            padding: 8px;
        }

        th {
            background-color: #e2e8f0;
            font-weight: 600;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .styled-select {
            background-color: lightblue;
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <script>
        function updateStatus(PurcOrder, status) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    console.log(this.responseText);
                }
            }
            xhr.send("id=" + PurcOrder + "&cond=PurcOrder" + "&status=" + status + "&table=purchordertable");
        }
    </script>
    <div id="maindiv">
        <div id="topdiv">
            <ul class="top-buttons">

                <a href="PurchaseOrder.php" target="_blank">
                    <button class="sidebar-button">Create Order</button>
                </a>
                <a href="inventorynew.php" target="_blank">
                    <button class="sidebar-button">Create Inventory</button>
                </a>
                <a href="kanban.php" target="_blank">
                    <button class="sidebar-button">Process Outcome</button>
                </a>
                <a href="login.html">
                    <button class="sidebar-button">Logout</button>
                </a>
        </div>
        <div id="rightdiv">
            <div id="heading">Dashboard
                <h6>Here is a summary of overall data</h6>
            </div>
            <div class="total-row">
                <div class="total-box">
                    <a href="orderplandisplay.php" target="_blank">
                        <button class="dash-button">Order Plan Display</button>
                    </a>
                </div>
                <div class="total-box">
                    <a href="inventorydisplay.php" target="_blank">
                        <button class="dash-button">Inventory Display</button>
                    </a>
                </div>
                <div class="total-box">
                    <a href="POdisplay.php" target="_blank">
                        <button class="dash-button">Order Display</button>
                    </a>
                </div>
                <div class="total-box">
                    <a href="Report.html" target="_blank">
                        <button class="dash-button">Report</button>
                    </a>
                </div>
            </div>
            <div class="data-container">

                <?php
                include("connection.php");

                // Retrieve data from the database
                $query = "SELECT *, 
    SUM(iteminfo.OrderQuantity) AS Quantity
FROM purchordertable
INNER JOIN iteminfo ON purchordertable.PurcOrder = iteminfo.PurcOrder
GROUP BY purchordertable.PurcOrder";
                $result = mysqli_query($conn, $query);

                echo "<h2>Recent Orders</h2>";
                echo "<div style='overflow-x:auto;'>
            <table>
                <tr>
                    <th>Production Order NO</th>
                    <th>Purchase Order NO</th>
                    <th>Item Code</th>
                    <th>Total Quantity</th>
                    <th>Status</th>
                    <th>Invoice</th>
                    <th>Order Plan</th> 
                </tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                  <td>{$row['ProdOrder']}</td>
                  <td>{$row['PurcOrder']}</td>
                  <td>{$row['ItemCode']}</td>
                  <td>{$row['Quantity']}</td>
                  <td>
                  <select 
                    onchange='updateStatus(\"{$row['PurcOrder']}\", this.value)' 
                    class='styled-select'
                  >";

                    echo "<option value='completed'" . ($row['status'] === 'completed' ? ' selected' : '') . ">Completed</option>";
                    echo "<option value='incomplete'" . ($row['status'] !== 'completed' ? ' selected' : '') . ">Incomplete</option>";

                    echo "</select>
                  </td>
                  <td>
                    <a href='invoicePO.php?ProdOrder={$row['ProdOrder']}&OrderType={$row['OrderType']}&PurcOrder={$row['PurcOrder']}&UOM={$row['UOM']}&IssueDate={$row['IssueDate']}&CompletionDate={$row['CompletionDate']}&ItemCode={$row['ItemCode']}&PackingType={$row['PackingType']}&Description={$row['Description']}&Quantity={$row['Quantity']}' target='_blank'>View Invoice</a>
                   
                  </td>
                  <td>
                  <a href='OrderPlan.php?ProdOrder={$row['ProdOrder']}&PurcOrder={$row['PurcOrder']}&Quantity={$row['Quantity']}' target='_blank'>Create OP</a>
                  </td>
                  </tr>";
                }

                echo "</table>
        </div>";

                mysqli_close($conn);
                ?>
            </div>

            <div class="data-container">
                <?php
                include("connection.php");

                // Retrieve data from the database
                $query = "SELECT inventorytable.id AS InventoryId, inventorytable.TotalQuantity, inventorytable.SupplierName,
                     stocks.ItemName, stocks.Quantity, stocks.Price
              FROM inventorytable
              LEFT JOIN stocks ON inventorytable.id = stocks.InventoryId";
                $result = mysqli_query($conn, $query);

                echo "<h2>Inventory Details</h2>";
                echo "<div style='overflow-x:auto;'>
            <table>
                <tr>
                    <th>Inventory Id</th>
                    <th>Supplier Name</th>
                    <th>Invoice</th> <!-- New column for the action button -->
              
                   
                </tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
        <td>{$row['InventoryId']}</td>
        <td>{$row['SupplierName']}</td>
        <td><a href='invoiceinventory.php?TotalQuantity={$row['TotalQuantity']}&SupplierName={$row['SupplierName']}&ItemName={$row['ItemName']}&Quantity={$row['Quantity']}&Price={$row['Price']}' target='_blank'>View Invoice</a></td>
      </tr>";
                }



                echo "</table>
        </div>";

                mysqli_close($conn);
                ?>
            </div>

        </div>
    </div>

</body>

</html>
