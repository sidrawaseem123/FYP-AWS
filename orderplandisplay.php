<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stitching Production Data</title>
    <style>
        /* Common table styles */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Additional styles for specific tables */
        /* Styling the first table */
        #stitching-table th {
            background-color: #4CAF50;
            color: white;
        }

        #stitching-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Styling the second table */
        #grading-table th {
            background-color: #007bff;
            color: white;
        }

        #grading-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Styling the third table */
        #packing-table th {
            background-color: #dc3545;
            color: white;
        }

        #packing-table tr:nth-child(even) {
            background-color: #f8d7da;
        }
    </style>
</head>
<body>
    <h2>Stitching Production Data</h2>
    <table>
        <thead>
            <tr>
                <th>Total</th>
                <th>Waste Count</th>
                <th>Remaining</th>
                <th>Pieces Size</th>
                <th>Pieces Formed</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include the connection file
            include 'connection.php';

            // Fetch data from the database
            $query = "SELECT * FROM stitchings";
            $result = mysqli_query($conn, $query);

            // Loop through the data and display it in table rows
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['Total'] . "</td>";
                echo "<td>" . $row['WasteCount'] . "</td>";
                echo "<td>" . $row['Remaining'] . "</td>";
                echo "<td>" . $row['PiecesSize'] . "</td>";
                echo "<td>" . $row['PiecesFormed'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Grading Production Data</h2>
    <table>
        <thead>
            <tr>
                <th>Pieces Formed</th>
                <th>Machine Allotted</th>
                <th>Labor Allotted</th>
                <th>Grade Type</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch grading data from the database
            $queryGrading = "SELECT * FROM grading";
            $resultGrading = mysqli_query($conn, $queryGrading);

            // Loop through the grading data and display it in table rows
            while ($rowGrading = mysqli_fetch_assoc($resultGrading)) {
                echo "<tr>";
                echo "<td>" . $rowGrading['PiecesFormed'] . "</td>";
                echo "<td>" . $rowGrading['MachineAllotted'] . "</td>";
                echo "<td>" . $rowGrading['LaborAllotted'] . "</td>";
                echo "<td>" . $rowGrading['GradeType'] . "</td>";
                echo "<td>" . $rowGrading['Value'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Packing Production Data</h2>
    <?php
// Include the connection file
include 'connection.php';

// Retrieve data from the database
$query = "SELECT * FROM packing";
$result = mysqli_query($conn, $query);

// Check if records exist
if (mysqli_num_rows($result) > 0) {
    // Display table header
    echo "<table border='1'>";
    echo "<tr><th>Grading Type</th><th>Pieces</th><th>Packing Type</th><th>Packing Info</th><th>Packing Status</th></tr>";
    
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['grading_type'] . "</td>";
        echo "<td>" . $row['pieces'] . "</td>";
        echo "<td>" . $row['packing_type'] . "</td>";
        echo "<td>" . $row['packing_info'] . "</td>";
        echo "<td>" . $row['packing_status'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "0 results";
}

// Close the connection
mysqli_close($conn);
?>

</body>
</html>
