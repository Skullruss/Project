<?php
// Include configuration
require 'config.php'; // Ensure this path is correct

// Create a new MySQLi instance
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Send a JSON response with an error message
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Prepare and execute the query
$sql = 'SELECT * FROM mwrhwfte_blackvoid.dat_background';
$stmt = $conn->prepare($sql);

if (!$stmt) {
    // Send a JSON response with an error message
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Failed to prepare SQL query']);
    exit;
}

$stmt->execute();

// Fetch the results
$result = $stmt->get_result();
$backgrounds = array();

while ($row = $result->fetch_assoc()) {
    $backgrounds[] = array(
        'id' => $row['backgroundid'],
        'name' => $row['backgroundname'],
        'description' => $row['backgrounddescription'], // Include description
        'cost' => $row['backgroundcost'], // Include cost
        'sourcebookid' => $row['sourcebookid'],
        'backgroundtypekey' => $row['backgroundtypekey']
    );
}

// Set the content type to JSON and echo the results
header('Content-Type: application/json');
echo json_encode($backgrounds);

// Close the statement and connection
$stmt->close();
$conn->close();
?>
