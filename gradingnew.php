<?php include 'connection.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grading</title>
    <link rel="stylesheet" type="text/css" href="gradingstyles.css">
</head>
<body>
    <div class="container">
        <form id="production-data-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <h2>Department 2: Grading</h2>
            <div class="form-group">
                <label for="PiecesFormed">Pieces Formed:</label>
                <input type="number" id="total" name="total" value="<?php echo isset($_SESSION['piecesFormed']) ? htmlspecialchars($_SESSION['piecesFormed']) : ''; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="MachineAllotted">Machine Allotted:</label>
                <input type="text" id="MachineAllotted" name="MachineAllotted">
            </div>
            <div class="form-group">
                <label for="LaborAllotted">Labour Allotted:</label>
                <input type="text" id="LaborAllotted" name="LaborAllotted">
            </div>
            <table border="1" id="gradingRecord">
                <thead>
                    <tr>
                        <th>Grading Type:</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
            <div class="addbtn">
                <input type="button" onclick="addItem()" value="Add Item">
            </div>
            <div class="btn-container">
    <input type="submit" value="Save" name="submit" class="btn">
</div>

        </form>
    </div>

    <script>
        var types = ["A","B","C"];
        // Function to generate grading type dropdown options dynamically
        function generateTypeDropdown() {
            var dropdown = '<select id = "Gtype" name="Gtype[]">';
            for (var i = 0; i < types.length; i++) {
                dropdown += '<option value="' + types[i] + '">' + types[i] + '</option>';
            }
            dropdown += '</select>';
            return dropdown;
        }
        
        // Function to add a new row to the grading table
        function addItem() {
            var table = document.getElementById("gradingRecord");
            var row = table.insertRow();
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            cell1.innerHTML = generateTypeDropdown();
            cell2.innerHTML = '<input type="text" name="Value[]" placeholder="Value">';
            cell3.innerHTML = '<button class="delete-btn" onclick="deleteRow(this)">Delete</button>';
        }

        // Function to delete a row from the grading table
        function deleteRow(btn) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>

<?php

if (isset($_POST['submit'])) {
    var_dump($_SESSION);
    // Retrieve form data
    $piecesFormed = $_POST['total'];
    $machineAllotted = $_POST['MachineAllotted'];
    $laborAllotted = $_POST['LaborAllotted'];
    $types = $_POST['Gtype'];
    $values = $_POST['Value'];
    $purcOrder = isset($_SESSION['PurcOrder']) ? (int)$_SESSION['PurcOrder'] : 0;
    // Debugging: Check if PurcOrder is set and is a valid integer

    $checkPurcOrderQuery = "SELECT PurcOrder FROM purchordertable WHERE PurcOrder = $purcOrder";
    $checkPurcOrderResult = mysqli_query($conn, $checkPurcOrderQuery);


    


    $queryGrading = "INSERT INTO grading
    (PiecesFormed, MachineAllotted, LaborAllotted ,GradeType, Value,status,PurcOrder) 
    VALUES";
    
    for ($i = 0; $i < count($types); $i++) {
        $type = $types[$i];
        $value = $values[$i];
        
        $queryGrading .= "('$piecesFormed','$machineAllotted','$laborAllotted','$type','$value','ToDo','$purcOrder'),";
        $_SESSION[$type] = $value;
    }
    
    $queryGrading = rtrim($queryGrading, ',');
    
    $data = mysqli_query($conn, $queryGrading);

    if ($data) {
        echo "Inserted successfully";
        header("Location: orderplan.php");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
?>