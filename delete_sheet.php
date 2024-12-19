<?php
session_start();
require 'config.php'; // Database configuration file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['sheetid'])) {
    $sheet_id = intval($_GET['sheetid']);

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Delete the sheet from the database
        $sql = "DELETE FROM dat_sheet WHERE sheetid = :sheetid AND userid = :userid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':sheetid' => $sheet_id, ':userid' => $user_id]);

        // Redirect back to the sheets page with a success message
        header("Location: sheets.php?message=Sheet deleted successfully");
        exit;
    } catch (PDOException $e) {
        // Handle the error
        header("Location: sheets.php?error=Error deleting sheet: " . $e->getMessage());
        exit;
    }
} else {
    // No sheet ID provided
    header("Location: sheets.php?error=No sheet ID provided");
    exit;
}
