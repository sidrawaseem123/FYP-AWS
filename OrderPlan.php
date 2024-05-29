<?php
session_start();
// Retrieve parameters from URL
if (isset($_GET['ProdOrder']) && isset($_GET['PurcOrder']) && isset($_GET['Quantity'])) {
    // If present in URL, retrieve values from URL
    $ProdOrder = $_GET['ProdOrder'];
    $PurcOrder = $_GET['PurcOrder'];
    $quantity = $_GET['Quantity'];

    // Save parameters in session variables
    $_SESSION['ProdOrder'] = $ProdOrder;
    $_SESSION['PurcOrder'] = $PurcOrder;
    $_SESSION['Quantity'] = $quantity;
} else {
    // If not present in URL, retrieve values from session
    $ProdOrder = $_SESSION['ProdOrder'];
    $PurcOrder = $_SESSION['PurcOrder'];
    $quantity = $_SESSION['Quantity'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Plan</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #1a202c;
}

header {
    background-color: #1a202c;
    color: #fff;
    text-align: center;
    padding: 1em 0;
}

form {
    width: 90%;
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

section {
    margin-bottom: 20px;
}

h2 {
    color: #1a202c;
}

.button {
    display: block;
    width: 100%;
    padding: 10px;
    font-size: 16px;
    margin: 10px 0;
    text-decoration: none;
    background-color: #1a202c;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.button:hover {
    background-color: #030b38;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #1a202c;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

/* Style radio buttons inline */
.departments label {
    display: block;
    margin-bottom: 10px;
}

.departments input[type="radio"] {
    display: inline-block;
    margin-right: 5px;
}

    </style>
</head>
<body>

<header>
    
</header>

<form id="production-form">
    <h1>Production Plan</h1>
    <section>
        <div class="form-group">
            <label for="ProdOrder">Production Order NO:</label>
            <input type="text" id="ProdOrder" name="ProdOrder" value="<?php echo htmlspecialchars($ProdOrder); ?>" readonly>

        </div>

        <div class="form-group">
            <label for="PurcOrder">Purchase Order NO:</label>
            <input type="text" id="ProdOrder" name="ProdOrder" value="<?php echo htmlspecialchars($PurcOrder); ?>" readonly>
        </div>
    </section>

    <section>
        <h2>Process Dept 1</h2>
            <a href="Stitch.php?Quantity=<?php echo $quantity; ?>&ProdOrder=<?php echo $ProdOrder; ?>&PurcOrder=<?php echo $PurcOrder; ?>">
                <button type="button" class="button save-button" //onclick="submitProductionPlan('1')"//>Stitching</button>
            </a> 
    </section>

    <section>
        <h2>Process Dept 2</h2>
            <a href="gradingnew.php">
                <button type="button" class="button save-button" //onclick="submitProductionPlan('2')//">Grading</button>
            </a>
            
        </div>
    </section>

    <section>
        <h2>Process Dept 3</h2>

            <a href="packing.php">
                <button type="button" class="button save-button" //onclick="submitProductionPlan('3')"//>Packing</button>
            </a>
            
        </div>
    </section>
</form>

<!-- <script>
    function submitProductionPlan(department) {
        // Get form values for the selected department
        const material = document.getElementById(`Material${department}`).value;
        const labour = document.getElementById(`Labour${department}`).value;
        const machineAlloted = document.getElementById(`MachineAlloted${department}`).value;
        const outcome = document.querySelector(`input[name="outcome${department}"]:checked`);

        // Validate form data for the selected department
        if (!material || !labour || !machineAlloted || !outcome) {
            alert(`Please fill in all fields for Department ${department}.`);
            return;
        }

        // You can add logic here to send data to the server or perform other actions
        // For now, just clear the form for the selected department
        clearForm(department);
    }

    function clearForm(department) {
        // Clear the form for the selected department
        document.getElementById(`Material${department}`).value = "";
        document.getElementById(`Labour${department}`).value = "";
        document.getElementById(`MachineAlloted${department}`).value = "";
        document.querySelector(`input[name="outcome${department}"]:checked`).checked = false;
    }
</script> -->

</body>
</html>
