<?php
include("connection.php");

$id= $_POST['id']; //52
$cond = $_POST['cond']; 
$status = $_POST['status'];
$table = $_POST['table'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE $table SET status = ? WHERE $cond = ?";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("ss", $status, $id);

if ($stmt->execute()) {
    echo "Status updated successfully";
} else {
    echo "Error updating status: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
