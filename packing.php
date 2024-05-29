
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packing</title>
    <link rel="stylesheet" type="text/css" href="packing.css">
   
</head>
<body>
    <div class="container">
        <h2>Department 3: Packing</h2>
        <form id="production-data-form"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group">
                <label for="gradingAPieces">Pieces in Grading A:</label>
                <input type="number" id="gradingAPieces" name="gradingAPieces" onchange="updatePackingInfo('gradingA')" value="<?php echo isset($_SESSION['A']) ? htmlspecialchars($_SESSION['A']) : ''; ?>" readonly>
                <label for="gradingAType">Packing Type:</label>
                <select id="gradingAType" name="gradingAType" onchange="updatePackingInfo('gradingA')">
                    <option value="bundles">Bundles</option>
                    <option value="boxes">Boxes</option>
                </select>
                <div id="gradingA-packing-info" class="grading-info"></div>
                <div id="gradingA-status" class="status"></div>
            </div>
            <div class="form-group">
                <label for="gradingBPieces">Pieces in Grading B:</label>
                <input type="number" id="gradingBPieces" name="gradingBPieces" onchange="updatePackingInfo('gradingB')" value="<?php echo isset($_SESSION['B']) ? htmlspecialchars($_SESSION['B']) : ''; ?>" readonly>
                <label for="gradingBType">Packing Type:</label>
                <select id="gradingBType" name="gradingBType" onchange="updatePackingInfo('gradingB')">
                    <option value="bundles">Bundles</option>
                    <option value="boxes">Boxes</option>
                </select>
                <div id="gradingB-packing-info" class="grading-info"></div>
                <div id="gradingB-status" class="status"></div>
            </div>
            <div class="form-group">
                <label for="gradingCPieces">Pieces in Grading C:</label>
                <input type="number" id="gradingCPieces" name="gradingCPieces" onchange="updatePackingInfo('gradingC')" value="<?php echo isset($_SESSION['C']) ? htmlspecialchars($_SESSION['C']) : ''; ?>"  readonly>
                <label for="gradingCType">Packing Type:</label>
                <select id="gradingCType" name="gradingCType" onchange="updatePackingInfo('gradingC')">
                    <option value="bundles">Bundles</option>
                    <option value="boxes">Boxes</option>
                </select>
                <div id="gradingC-packing-info" class="grading-info"></div>
                <div id="gradingC-status" class="status"></div>
            </div>
        
            
            <div id="error-message" class="error-message"></div>
            <button type="submit" class="button save-button">Save</button>

            
        </form>
    </div>
    
    <script>
        function updatePackingInfo(gradingType) {
            var pieces = parseInt(document.getElementById(gradingType + "Pieces").value);
            var packingType = document.getElementById(gradingType + "Type").value;
            var infoElement = document.getElementById(gradingType + "-packing-info");
            var statusElement = document.getElementById(gradingType + "-status");
            var bundles = 0;
            var boxes = 0;

            if (packingType === "bundles") {
                bundles = Math.floor(pieces / 5);
                boxes = 0;
            } else if (packingType === "boxes") {
                boxes = Math.floor(pieces / 10);
                bundles = 0;
            }

            infoElement.textContent = "bundles: " + bundles + ", boxes: " + boxes;
            if (packingType === "bundles") {
                statusElement.textContent = (pieces % 5 === 0) ? "no pieces left in grading to be packed" : (pieces % 5) + " pieces remaining for next bundle";
            } else if (packingType === "boxes") {
                statusElement.textContent = (pieces % 10 === 0) ? "no pieces left in grading to be packed" : (pieces % 10) + " pieces remaining for next box";
            }
        }

        function validatePacking() {
            var gradingAPieces = parseInt(document.getElementById("gradingAPieces").value);
            var gradingBPieces = parseInt(document.getElementById("gradingBPieces").value);
            var gradingCPieces = parseInt(document.getElementById("gradingCPieces").value);
            var errorMessage = document.getElementById("error-message");

            if (isNaN(gradingAPieces) || isNaN(gradingBPieces) || isNaN(gradingCPieces)) {
                errorMessage.textContent = "Please enter valid numbers for all fields.";
                return;
            }

            if (gradingAPieces < 0 || gradingBPieces < 0 || gradingCPieces < 0) {
                errorMessage.textContent = "Please enter positive numbers for all fields.";
                return;
            }

            errorMessage.textContent = "";

            // Proceed with saving data
            savePackingData(gradingAPieces, gradingBPieces, gradingCPieces);
        }

        function savePackingData(gradingAPieces, gradingBPieces, gradingCPieces) {
            console.log("Pieces in Grading A:", gradingAPieces);
            console.log("Pieces in Grading B:", gradingBPieces);
            console.log("Pieces in Grading C:", gradingCPieces);
            // Further logic for saving data
        }
    </script>
</body>
</html>
<?php
// Include the connection file
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $gradingAPieces = $_POST['gradingAPieces'];
    $gradingAType = $_POST['gradingAType'];
    $gradingBPieces = $_POST['gradingBPieces'];
    $gradingBType = $_POST['gradingBType'];
    $gradingCPieces = $_POST['gradingCPieces'];
    $gradingCType = $_POST['gradingCType'];
    $purcOrder = isset($_SESSION['PurcOrder']) ? (int)$_SESSION['PurcOrder'] : 0;

    // Save packing data for Grading A
    savePackingData('A', $gradingAPieces, $gradingAType);

    // Save packing data for Grading B
    savePackingData('B', $gradingBPieces, $gradingBType);

    // Save packing data for Grading C
    savePackingData('C', $gradingCPieces, $gradingCType);

    echo "Packing data saved successfully.";
}

// Function to save packing data to the database
function savePackingData($gradingType, $pieces, $packingType) {
    global $conn, $purcOrder;

    // Calculate packing info
    $bundles = 0;
    $boxes = 0;
    if ($packingType === "bundles") {
        $bundles = floor($pieces / 5);
    } elseif ($packingType === "boxes") {
        $boxes = floor($pieces / 10);
    }
    $packingInfo = "bundles: $bundles, boxes: $boxes";

    // Calculate packing status
    if ($packingType === "bundles") {
        $packingStatus = ($pieces % 5 === 0) ? "no pieces left in grading to be packed" : ($pieces % 5) . " pieces remaining for next bundle";
    } elseif ($packingType === "boxes") {
        $packingStatus = ($pieces % 10 === 0) ? "no pieces left in grading to be packed" : ($pieces % 10) . " pieces remaining for next box";
    }

    // Construct and execute SQL query to insert data
    $query = "INSERT INTO packing (grading_type, pieces, packing_type, packing_info, packing_status, status, purcOrder) 
              VALUES ('$gradingType', '$pieces', '$packingType', '$packingInfo', '$packingStatus','ToDo','$purcOrder')";
    $data = mysqli_query($conn, $query);
    if ($data) {
        echo "<script>window.location.href = 'kanban.php';</script>";
        exit;
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
?>

