<?php
session_start();
require 'config.php'; // Database configuration file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['sheetName'])) {
        $sheet_name = trim($_POST['sheetName']);
        $sheet_type_key = 1; // 1 for Black Void

        try {
            // Connect to the database
            $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Start transaction
            $pdo->beginTransaction();

            // Insert new sheet record
            $sql = "INSERT INTO dat_sheet (userid, sheetname, sheettypekey) VALUES (:userid, :sheetname, :sheettypekey)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':userid' => $user_id,
                ':sheetname' => $sheet_name,
                ':sheettypekey' => $sheet_type_key
            ]);

            // Get the newly inserted sheet ID
            $sheet_id = $pdo->lastInsertId();

            // Insert empty character sheet record in blackvoid schema
            $sql = "INSERT INTO mwrhwfte_blackvoid.dat_charactersheet (userid, sheetid) VALUES (:userid, :sheetid)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':userid' => $user_id,
                ':sheetid' => $sheet_id
            ]);

            // Commit transaction
            $pdo->commit();

            // Redirect to the new character sheet
            header("Location: sheets_blackvoid.php?sheetid=" . $sheet_id);
            exit;
        } catch (PDOException $e) {
            // Rollback transaction on error
            $pdo->rollBack();
            header("Location: sheets.php?error=Error creating sheet: " . $e->getMessage());
            exit;
        }
    } else {
        // No sheet name provided
        header("Location: sheets.php?error=Sheet name is required");
        exit;
    }
} else {
    // Invalid request method
    header("Location: sheets.php?error=Invalid request");
    exit;
}
