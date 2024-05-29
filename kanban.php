<?php
@include('connection.php');

// Function to fetch data from the database
function fetchData($conn, $query) {
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_free_result($result);
    return $data;
}

// Fetch data for stitchings
$queryStitchings = "SELECT * FROM stitchings";
$stitchingsData = fetchData($conn, $queryStitchings);

// Fetch data for packing
$queryPacking = "SELECT * FROM packing";
$packingData = fetchData($conn, $queryPacking);

// Fetch data for grading
$queryGrading = "SELECT * FROM grading";
$gradingData = fetchData($conn, $queryGrading);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Chart Example</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
    }

    .main-container {
        display: flex;
        justify-content: space-between;
        margin: 20px;
    }

    .kanban-column {
        flex: 1;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .kanban-column h2 {
        margin-top: 0;
    }


    .kanban-entry {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        margin: 10px 0;
        cursor: pointer;
    }
</style>
</head>
<body>
    <h1 style="text-align: center;">Process Outcome</h1>
    <div class="main-container" id="kanbanContainer">
        <!-- Kanban entries will be dynamically added here -->
    </div>

    <script>
        // Include the fetched data directly in JavaScript as a JSON array
        const stitchingsData = <?php echo json_encode($stitchingsData); ?>;
    const packingData = <?php echo json_encode($packingData); ?>;
    const gradingData = <?php echo json_encode($gradingData); ?>;

    // Transform and merge all the data into a single array
    const allData = [
        ...stitchingsData.map(entry => ({ ...entry, type: 'stitching' })),
        ...packingData.map(entry => ({ ...entry, type: 'packing' })),
        ...gradingData.map(entry => ({ ...entry, type: 'grading' })),
    ];
    allData.sort((a, b) => a.PurcOrder - b.PurcOrder);
        
        const populateKanbanEntries = () => {
        const kanbanContainer = document.getElementById('kanbanContainer');

        // Create Kanban columns
        const kanbanColumnsHtml = `
            <div class="kanban-column" id="ToDo">
                <h2>TO DO</h2>
            </div>
            <div class="kanban-column" id="InQueue">
                <h2>IN QUEUE</h2>
            </div>
            <div class="kanban-column" id="Done">
                <h2>DONE</h2>
            </div>
        `;
        kanbanContainer.insertAdjacentHTML('beforeend', kanbanColumnsHtml);

        const todoColumn = document.getElementById('ToDo');
        const InQueueColumn = document.getElementById('InQueue');
        const DoneColumn = document.getElementById('Done');
        allData.forEach(entry => {
                let entryHtml;
                if (entry.type === 'stitching') {
                    entryHtml = `
                        <div class="kanban-entry" id="entry${entry.StitchingID}" data-id="${entry.StitchingID}" data-type="${entry.type}" draggable="true">
                            <h2>Order ID: ${entry.PurcOrder}</h2>
                            <h3>Stitching ID: ${entry.StitchingID}</h3>
                            <p>Total: ${entry.Total}, Waste Count: ${entry.WasteCount}, Remaining: ${entry.Remaining}, Machine Allotted: ${entry.MachineAllotted}, Labor Allotted: ${entry.LaborAllotted}, Pieces Size: ${entry.PiecesSize}, Pieces Formed: ${entry.PiecesFormed}</p>
                        </div>
                    `;
                } else if (entry.type === 'packing') {
                    entryHtml = `
                        <div class="kanban-entry" id="entry${entry.id}" data-id="${entry.id}" data-type="${entry.type}" draggable="true">
                            <h2>Order ID: ${entry.PurcOrder}</h2>
                            <h3>Packing ID: ${entry.id}</h3>
                            <p>Grading Type: ${entry.grading_type},</p>
                            <p> Pieces: ${entry.pieces},</p>
                            <p> Packing Info: ${entry.packing_info},</p>
                            <p>Packing Type: ${entry.packing_type}, </p>
                            <p>Packing Status: ${entry.packing_status},</p>
                            <p>Packing Data: ${entry.packing_data},</p>
                        </div>
                    `;
                } else if (entry.type === 'grading') {
                    entryHtml = `
                        <div class="kanban-entry" id="entry${entry.GradingID}" data-id="${entry.GradingID}" data-type="${entry.type}" draggable="true">
                            <h2>Order ID: ${entry.PurcOrder}</h2>
                            <h3>Grading ID: ${entry.GradingID}</h3>
                            <p> PiecesFormed: ${entry.PiecesFormed}, </p>
                            <p>Grade: ${entry.Grade},</p>
                            <p>GradeType: ${entry.GradeType},</p>
                            <p>Value: ${entry.Value},</p>
                            <p>MachineAllotted: ${entry.MachineAllotted},</p>
                            <p>LaborAllotted: ${entry.LaborAllotted},</p>
                        </div>
                    `;
                }

                switch (entry.status) {
                    case 'ToDo':
                        todoColumn.insertAdjacentHTML('beforeend', entryHtml);
                        break;
                    case 'InQueue':
                        InQueueColumn.insertAdjacentHTML('beforeend', entryHtml);
                        break;
                    case 'Done':
                        DoneColumn.insertAdjacentHTML('beforeend', entryHtml);
                        break;
                    default:
                        console.error(`Unknown status: ${entry.status}`);
                }
            });


    // Add event listeners for drag and drop
    const kanbanEntries = document.querySelectorAll('.kanban-entry');
    kanbanEntries.forEach(entry => {
        entry.addEventListener('dragstart', handleDragStart);
    });

    const kanbanColumns = document.querySelectorAll('.kanban-column');
    kanbanColumns.forEach(column => {
        column.addEventListener('dragover', handleDragOver);
        column.addEventListener('drop', handleDrop);
    });
    
};


const handleDragStart = (event) => {
    event.dataTransfer.setData('text/plain', event.target.id);
};

const handleDragOver = (event) => {
    event.preventDefault();
};
const handleDrop = (event) => {
            event.preventDefault();
            const id = event.dataTransfer.getData('text/plain');
            const draggableElement = document.getElementById(id);
            const dropzone = event.target.closest('.kanban-column');
            if (!dropzone) return;

            dropzone.appendChild(draggableElement);
            event.dataTransfer.clearData();

            // Get the new status from the id of the dropzone
            const newStatus = dropzone.id;

            // Get the id and type of the entry from the data attributes
            const entryId = draggableElement.getAttribute('data-id');
            const entryType = draggableElement.getAttribute('data-type');
            console.log(`entryId: ${entryId}, entryType: ${entryType}`);
            // Determine the table and condition based on the type
            let table, cond;
            switch (entryType) {
                case 'stitching':
                    table = 'stitchings';
                    cond = 'StitchingID';
                    break;
                case 'packing':
                    table = 'packing';
                    cond = 'id';
                    break;
                case 'grading':
                    table = 'grading';
                    cond = 'GradingID';
                    break;
            }

                // Make an AJAX call to update the status in the database
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_status.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                // Prepare the data
                const data = `id=${entryId}&status=${newStatus}&cond=${cond}&table=${table}`;

                // Send the data
                xhr.send(data);
            };

        // Populate the Kanban entries using the sorted, merged array
        populateKanbanEntries();
    </script>
</body>
</html>
