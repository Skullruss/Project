<?php
// config.php
$base_url = 'http://localhost/alchemicarts'; // Default to local

if ($_SERVER['HTTP_HOST'] === 'alchemic-arts.com') {
    $base_url = 'https://alchemic-arts.com'; // Hosted URL
}

// $servername = "localhost"; // Database server
// $username = "root"; // Your database username
// $password = ""; // Your database password
// $dbname = "alchemicarts"; // Your database name

//prod info
$servername = "localhost"; // Database server
$username = "EMAIL"; // Your database username
$password = "PASSWORD"; // Your database password
$dbname = "mwrhwfte_alchemicarts"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
