<?php
session_start();
require 'config.php'; // Database configuration file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'navbar.php'; ?>
    <?php
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    ?>
    
    <h1 class="text-center page-title">About Us</h1>
    <hr>
</body>
</html>
