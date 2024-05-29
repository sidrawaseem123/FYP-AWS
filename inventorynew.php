<?php include("connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory</title>
    <link rel="stylesheet" type="text/css" href="inventorystyle.css">
</head>
<body>
    <!-- Modify the form to include hidden input for InventoryId -->
<form id="inventoryForm" method="post">
    <h1>Inventory</h1>
    <div class="form-group">
        <label for="id">Inventory Id</label>
        <input type="number" id="id" name="id" required>  
    </div>

    <div class="form-group">
        <label for="TotalQuantity">Total Quantity</label>
        <input type="number" id="TotalQuantity" name="TotalQuantity" required>  
    </div>
      
    <div class="form-group">
        <label for="SupplierName">Supplier Name:</label>
        <input type="text" id="SupplierName" name="SupplierName" required>
    </div>

    <table border="1" id="inventoryRecord">
        <thead>
            <tr>
                <th>Color</th>
                <th>Quantity</th>
                <th>Price per KG</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
      
    <div class="addbtn">
        <input type="button" onclick="addItem()" value="Add Item">
    </div>
          
    <br>
    <div class="form-group">
        <button type="submit" name="submit">Add to Inventory</button>
    </div>
    
</form>

</body>
    <script>
        // List of colors for the dropdown
        var colors = ["Red", "Blue", "Green", "Yellow", "Black", "White"];
        
        function generateColorDropdown() {
            var dropdown = '<select name="Color[]">';
            for (var i = 0; i < colors.length; i++) {
                dropdown += '<option value="' + colors[i] + '">' + colors[i] + '</option>';
            }
            dropdown += '</select>';
            return dropdown;
        }
        
        function addItem() {
    var table = document.getElementById("inventoryRecord");
    // var table = document.getElementById("inventoryRecord").getElementsByTagName('tbody')[0];
    var row = table.insertRow();
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
            
    cell1.innerHTML = generateColorDropdown();
    cell2.innerHTML = '<input type="text" name="Quantity[]" placeholder="Quantity">';
    cell3.innerHTML = '<input type="number" name="Price[]" placeholder="Price per KG">';
    cell4.innerHTML = '<button class="delete-btn" onclick="deleteRow(this)">Delete</button>';
}

        function deleteRow(btn) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>
</html>
<?php
include("connection.php"); // Assuming this file contains your database connection details

if (isset($_POST['submit'])) { 
    // Form is submitted
    $TotalQuantity = $_POST['TotalQuantity'];
    $SupplierName = $_POST['SupplierName'];
    $Color = $_POST['Color'];
    $Quantity = $_POST['Quantity'];
    $Price = $_POST['Price'];

    // Insert data into 'inventorytable' table without specifying id
    $queryInventory = "INSERT INTO inventorytable (TotalQuantity, SupplierName) 
                        VALUES ('$TotalQuantity', '$SupplierName')";

    // Execute the query to insert data into 'inventorytable'
    $data = mysqli_query($conn, $queryInventory);

    if ($data) {
        // Get the last inserted id from the 'inventorytable'
        $lastInsertedId = mysqli_insert_id($conn);

        // Prepare and execute the query to insert data into 'stocks' table
        $queryStocks = "INSERT INTO stocks (ItemName, Quantity, Price, InventoryId) VALUES ";
        for ($i = 0; $i < count($Color); $i++) {
            $itemName = $Color[$i];
            $quantity = $Quantity[$i];
            $price = $Price[$i];

            $queryStocks .= "('$itemName', '$quantity', '$price', '$lastInsertedId'),";
        }
        $queryStocks = rtrim($queryStocks, ','); // Remove the trailing comma

        // Execute the query to insert data into 'stocks' table
        $data2 = mysqli_query($conn, $queryStocks);

        if ($data2) {
            // Insertion into 'stocks' successful
            echo "Data inserted into stocks successfully<br>";
        } else {
            // Error occurred while inserting into 'stocks'
            echo "Failed to insert data into stocks: " . mysqli_error($conn) . "<br>";
        }
    } else {
        // Error occurred while inserting into 'inventorytable'
        echo "Failed to insert data into inventorytable: " . mysqli_error($conn) . "<br>";
    }

    mysqli_close($conn); // Close the database connection
}
?>
