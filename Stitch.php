<?php
    include 'connection.php';
    session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stitching</title>
    <link rel="stylesheet" type="text/css" href="stitching.css">
</head>
<body>
    <div class="container">
        <h2>Department 1: Stitching</h2>
        <form id="production-data-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="total">Total:</label>
            <input type="number" id="total" name="total" value="<?php echo isset($_SESSION['Quantity']) ? htmlspecialchars($_SESSION['Quantity']) : ''; ?>" readonly>
        </div>
            <div class="form-group">
                <label for="waste">Waste Count:</label>
                <input type="number" id="waste" name="waste" oninput="calculateRemaining()" required>
            </div>
            <div class="form-group">
                <label for="remaining">Remaining:</label>
                <input type="number" id="remaining" name="remaining" readonly>
            </div>
            <div class="form-group">
                <label for="piecesSize">Pieces Size:</label>
                <select id="piecesSize" name="piecesSize" onchange="calculatePiecesFormed()">
                    <option value="2X2">12X12</option>
                    <option value="2X4">16X30</option>
                    <option value="4X4">31X57</option>
                    <option value="6X6">38X67</option>
                </select>
            </div>
            <div class="form-group">
                <label for="piecesFormed">Pieces Formed:</label>
                <input type="number" id="piecesFormed" name="piecesFormed" readonly>
            </div>
            <div class="form-group">
                <label for="machineAllotted">Machine Allotted:</label>
                <input type="text" id="machineAllotted" name="machineAllotted">
            </div>
            <div class="form-group">
                <label for="laborAllotted">Labour Allotted:</label>
                <input type="text" id="laborAllotted" name="laborAllotted">
            </div>
            <button type="submit" class="button save-button">Save</button>
        </form>
    </div>

    <script>
        function calculateRemaining() {
            var total = parseInt(document.getElementById("total").value);
            var waste = parseInt(document.getElementById("waste").value);
            if (!isNaN(total) && !isNaN(waste)) {
                document.getElementById("remaining").value = total - waste;
            }
            calculatePiecesFormed();
        }

        function calculatePiecesFormed() {
            var piecesSize = document.getElementById("piecesSize").value;
            var remaining = parseInt(document.getElementById("remaining").value);
            var piecesFormed = 0;
            switch (piecesSize) {
                case "2X2":
                    piecesFormed = Math.floor(remaining / (50 / 1000)); // 50g to kg
                    break;
                case "2X4":
                    piecesFormed = Math.floor(remaining / (150 / 1000)); // 150g to kg
                    break;
                case "4X4":
                    piecesFormed = Math.floor(remaining / (470 / 1000)); // 470g to kg
                    break;
                case "6X6":
                    piecesFormed = Math.floor(remaining / (630 / 1000)); // 630g to kg
                    break;
            }
            document.getElementById("piecesFormed").value = piecesFormed;
        }
    </script>

  <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $total = $_POST['total'];
        $waste = $_POST['waste'];
        $remaining = $_POST['remaining'];
        $piecesSize = $_POST['piecesSize'];
        $piecesFormed = $_POST['piecesFormed'];
        $machineAllotted = $_POST['machineAllotted'];
        $laborAllotted = $_POST['laborAllotted'];
        $_SESSION['piecesFormed'] = $piecesFormed;
        $purcOrder = isset($_SESSION['PurcOrder']) ? (int)$_SESSION['PurcOrder'] : 0;
        
        //var_dump($_SESSION); // Output all session variables for debugging
        

        $query = "INSERT INTO stitchings (Total, WasteCount, Remaining, PiecesSize, PiecesFormed,MachineAllotted,LaborAllotted,status,PurcOrder) 
                  VALUES ('$total', '$waste', '$remaining', '$piecesSize', '$piecesFormed','$machineAllotted','$laborAllotted','ToDo','$purcOrder')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Data inserted successfully.')</script>";
            header("Location: orderplan.php");
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "')</script>";
        }
    }
    ?>

    
</body>
</html>
