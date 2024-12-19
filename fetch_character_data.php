<?php
// Include configuration
require 'config.php'; // Ensure this path is correct

// Start session to access user_id
session_start();

// Check if the user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Create a new MySQLi instance
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Send a JSON response with an error message
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Get the sheetid from the query parameter
$sheetid = $_GET['sheetid'] ?? null;

// Validate sheetid
if (!$sheetid || !is_numeric($sheetid)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid sheet ID']);
    exit;
}

// Get the current user's ID from the session
$user_id = $_SESSION['user_id'] ?? null;

// Prepare and execute the query to check if the sheetid exists in the dat_sheet table
$sql = 'SELECT userid FROM mwrhwfte_alchemicarts.dat_sheet WHERE sheetid = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $sheetid);
$stmt->execute();
$stmt->store_result();

// Check if the sheet exists
if ($stmt->num_rows === 0) {
    // No sheet found with the given sheetid
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Character sheet not found']);
    exit;
}

// Fetch the result to check if the userid matches
$stmt->bind_result($stored_userid);
$stmt->fetch();

// Compare the stored userid with the current session's user_id
if ($stored_userid !== $user_id) {
    header('Content-Type: application/json');
    echo json_encode(['error' => "You don't own this page"]);
    exit;
}

// Prepare and execute the query for character data
$sql = 'SELECT * FROM mwrhwfte_blackvoid.dat_charactersheet WHERE sheetid = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $sheetid);
$stmt->execute();

// Fetch the character data
$result = $stmt->get_result();
$character = $result->fetch_assoc();

if (!$character) {
    // No character found
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Character not found']);
    exit;
}

// Set the content type to JSON and echo the character data
header('Content-Type: application/json');
echo json_encode($character);

// Close the statement and connection
$stmt->close();
$conn->close();
?>
