<?php
require 'config.php'; // Database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $backup = $_POST['backup'];
    $first = $_POST['first'];
    $last = $_POST['last'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Error: Passwords do not match. Please go back and try again.";
        exit();
    }

    // Check if email and backup email are the same
    if ($email === $backup) {
        echo "Error: Email and Backup Email cannot be the same. Please go back and try again.";
        exit();
    }

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM dat_user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($email_count);
    $stmt->fetch();
    $stmt->close();

    if ($email_count > 0) {
        echo "Error: This email is already registered. Please use a different email or <a href='login.php'>login</a>.";
    } else {
        // Generate a salt
        $salt = bin2hex(random_bytes(16));
        // Hash the password with the salt
        $hashed_password = hash('sha256', $password . $salt);

        // Prepare the insert statement to save all fields
        $stmt = $conn->prepare(
            "INSERT INTO dat_user (email, password, salt, backupemail, firstname, lastname) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssssss", $email, $hashed_password, $salt, $backup, $first, $last);

        if ($stmt->execute()) {
            // Redirect to login page
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>
