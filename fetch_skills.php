<?php
// Include database connection file
require_once 'config.php'; // Adjust the path if necessary

// Check if 'sheetid' is set and is a valid integer
if (isset($_GET['sheetid']) && is_numeric($_GET['sheetid'])) {
    $sheetid = intval($_GET['sheetid']); // Sanitize the input

    // Prepare the SQL query
    $sql = "SELECT skillid, skillrank, miscmodifier, keytraitid, specialization
            FROM mwrhwfte_blackvoid.dat_userskill
            WHERE charactersheetid = ?";

    // Prepare the statement using the existing $conn from config.php
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter
        $stmt->bind_param("i", $sheetid);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch all rows as an associative array
        $skills = $result->fetch_all(MYSQLI_ASSOC);

        // Return the results as JSON
        header('Content-Type: application/json');
        echo json_encode($skills);

        // Close the statement
        $stmt->close();
    } else {
        // Error preparing the SQL statement
        echo json_encode(["error" => $conn->error]);
    }
} else {
    // Invalid or missing 'sheetid'
    echo json_encode(["error" => "Invalid or missing sheetid"]);
}
?>