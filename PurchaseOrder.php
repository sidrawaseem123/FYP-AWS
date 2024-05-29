<?php include("connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Purchase Order</title>
  <link rel="stylesheet" type="text/css" href="POstyle.css">
</head>
<body>
<form action="" method="post">
    <h2>PURCHASE ORDER</h2>
    <div class="form-group">
      <label for="ProdOrder">Production Order NO:</label>
      <input type="text" id="ProdOrder" name="ProdOrder">
    </div>

    <div class="form-group">
      <label for="OrderType">Order Type:</label>
      <input type="text" id="OrderType" name="OrderType">
    </div>
    <h4>Towels</h4>

    <div class="form-group">
      <label for="UOM">Unit of Measure:</label>
      <select name="UOM" id="UOM">
      <option value="KGs">KGs</option>
    </select>
    </div>

     <div class="form-group">
      <label for="IssueDate">Issue Date:</label>
      <input type="date" id="IssueDate" name="IssueDate">
     </div>

    <div class="form-group">
      <label for="CompletionDate">Estimated Complition Date:</label>
      <input type="date" id="CompletionDate" name="CompletionDate">
    </div>

    <div class="form-group">
      <label for="ItemCode">Item Code:</label>
      <input type="number" id="ItemCode" name="ItemCode">
    </div>

    <div class="form-group">
      <label for="PackingType">Packing Type:</label>
      <select name="PackingType" id="PackingType">
      <option value="Bundles">Bundles</option>
      <option value="Boxes">Boxes</option>
    </select>
    </div>

    </div>
    <div class="form-group">
      <label for="Description">Item Description:</label>
      <input type="text" id="Description" name="Description">
    </div>

    <table border="1" id="orderList">
      <thead>
        <tr>
          
          <th>Color</th>
          <th>Size</th>
          <th>Order Quantity</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>

    <div class="addbtn">
      <input type="button" onclick="addItem()" value="Add Item">
    </div>
    
    </div> 
    <br>
    <div class="btn">
    <input type="submit" value="submit" name="submit">
    </div>
  
  </form>
</body>
<script>
    // List of colors for the dropdown
  var colors = ["Red", "Blue", "Green", "Yellow", "Black", "White"];

function generateColorDropdown() {
  var dropdown = '<select id="Color" name="Color[]">';
  for (var i = 0; i < colors.length; i++) {
    dropdown += '<option value="' + colors[i] + '">' + colors[i] + '</option>';
  }
  dropdown += '</select>';
  return dropdown;
}

function addItem() {
  var table = document.getElementById("orderList");
  var row = table.insertRow();
  var cell1 = row.insertCell(0);
  var cell2 = row.insertCell(1);
  var cell3 = row.insertCell(2);
  var cell4 = row.insertCell(3);
  // var cell5 = row.insertCell(4);

  // cell1.innerHTML = '<input type="number" id="Item_id" placeholder="Item No">';
  cell1.innerHTML = generateColorDropdown();
  cell2.innerHTML = '<input type="text" id="Size" name="Size[]" placeholder="Size">';
  cell3.innerHTML = '<input type="number" id="OrderQuantity" name="OrderQuantity[]" placeholder="Quantity">';
  cell4.innerHTML = '<button class="delete-btn" onclick="deleteRow(this)">Delete</button>';
}

function deleteRow(btn) {
  var row = btn.parentNode.parentNode;
  row.parentNode.removeChild(row);
}

</script>
</html>

<?php  
  
  if (isset($_POST['submit'])) {
  
  $ProdOrder = $_POST["ProdOrder"];
  $OrderType = $_POST["OrderType"];
  $UOM = $_POST["UOM"];
  $IssueDate = $_POST["IssueDate"];
  $CompletionDate = $_POST["CompletionDate"];
  $ItemCode = $_POST["ItemCode"];
  $PackingType = $_POST["PackingType"];
  $Description = $_POST["Description"];
  $Color = $_POST["Color"];
  $Size = $_POST["Size"];
  $OrderQuantity = $_POST["OrderQuantity"];
  $status = "incomplete";

  
  $queryOrder = "INSERT INTO purchordertable 
  (ProdOrder, OrderType, UOM, IssueDate, CompletionDate, ItemCode, PackingType, Description, status)
  VALUES 
  ('$ProdOrder', '$OrderType', '$UOM', '$IssueDate', '$CompletionDate', '$ItemCode', '$PackingType', '$Description', '$status')";
  $data = mysqli_query($conn, $queryOrder);
  $primaryKey = mysqli_insert_id($conn);

  $queryOrder2 = "INSERT INTO iteminfo (Color, Size, OrderQuantity, purcOrder) VALUES ";

  for ($i = 0; $i < count($Color); $i++) {
      $color = $Color[$i];
      $size = $Size[$i];
      $orderQuantity = $OrderQuantity[$i];
      $queryOrder2 .= "('$color', '$size', '$orderQuantity', '$primaryKey'),";
  }
  
  // Remove the trailing comma and execute the query
  $queryOrder2 = rtrim($queryOrder2, ','); // Remove the trailing comma
  echo "Order Details : " . $queryOrder2;
  
  $data2 = mysqli_query($conn, $queryOrder2);
    

    if ($data) {
        echo "Data inserted successfully";
        header("Location: dashboard.php");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
  
  }
  ?>
  








