<?php
include 'connection.php';

// Execute SELECT query to retrieve data from the grading table
$querySelect = "SELECT * FROM grading";
$result = mysqli_query($conn, $querySelect);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    // Output table header
    echo "<table border='1'>";
    echo "<tr><th>Grading ID</th><th>Pieces Formed</th><th>Machine Allotted</th><th>Labour Allotted</th><th>Grade Type</th><th>Value</th></tr>";

    // Loop through each row of the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Output data for each row
        echo "<tr>";
        echo "<td>" . $row['GradingID'] . "</td>";
        echo "<td>" . $row['PiecesFormed'] . "</td>";
        echo "<td>" . $row['MachineAllotted'] . "</td>";
        echo "<td>" . $row['LaborAllotted'] . "</td>";
        echo "<td>" . $row['GradeType'] . "</td>";
        echo "<td>" . $row['Value'] . "</td>";
        echo "</tr>";
    }

    // Close table tag
    echo "</table>";
} else {
    // No rows returned
    echo "No data found.";
}

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>
