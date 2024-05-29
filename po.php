<?php
include("connection.php");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM purchordertable WHERE PurcOrder = '$delete_id'";
    if (!mysqli_query($conn, $delete_query)) {
        echo "Error deleting record: " . mysqli_error($conn);
        exit();
    } else {
        echo "Record deleted successfully!";
    }
}

// Handle update action
if (isset($_POST['update'])) {
    // Retrieve data from the form
    $purcOrder = $_POST['purcOrder'];
    $orderQuantity = $_POST['orderQuantity'];

    // Update query
    $update_query = "UPDATE purchordertable SET OrderQuantity = '$orderQuantity' WHERE PurcOrder = '$purcOrder'";
    if (!mysqli_query($conn, $update_query)) {
        echo "Error updating record: " . mysqli_error($conn);
        exit();
    } else {
        echo "Record updated successfully!";
    }
}

// Retrieve data from the database
$query = "SELECT * FROM purchordertable INNER JOIN iteminfo ON purchordertable.PurcOrder=iteminfo.PurcOrder";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error retrieving data: " . mysqli_error($conn);
    exit();
}

// Check if there are any returned rows
if (mysqli_num_rows($result) == 0) {
    echo "No data found!";
    exit();
}

// Display retrieved data
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
                <th>Total Quantity</th>
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
            <td>{$row['Quantity']}</td>
            <td>{$row['id']}</td>
            <td>{$row['Color']}</td>
            <td>{$row['Size']}</td>
            <td>{$row['OrderQuantity']}</td>
            <td class='actions'>
                <form method='post' action=''>
                    <input type='hidden' name='purcOrder' value='{$row['PurcOrder']}'>
                    <input type='number' name='orderQuantity' value='{$row['OrderQuantity']}' required>
                    <input type='submit' name='update' value='Update'>
                </form>
                <a href='?delete_id={$row['PurcOrder']}' class='delete-btn'>Delete</a>
            </td>
          </tr>";
}

echo "</table>
    </div>";

mysqli_close($conn);
?>
