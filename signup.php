<?php
require 'config.php'; // Database configuration file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your external CSS file -->
</head>
<body>
<script>
    function showPassword() {
        var x = document.getElementById("password");
        var y = document.getElementById("confirm_password");
        if (x.type === "password") {
            x.type = "text";
            y.type = "text";
        } else {
            x.type = "password";
            y.type = "password";
        }
    }

    function validateEmail(email) {
        // Check if the email contains '@' and a '.' after '@'
        var atIndex = email.indexOf('@');
        var dotIndex = email.indexOf('.', atIndex);
        if (atIndex === -1 || dotIndex === -1 || dotIndex === email.length - 1) {
            alert("Please enter a valid email address (e.g., example@gmail.com).");
            return false;
        }
        return true;
    }

    function validateForm() {
        var email = document.getElementById("email").value;
        var backupEmail = document.getElementById("backup").value;
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;

        // Validate email and backup email
        if (!validateEmail(email) || !validateEmail(backupEmail)) {
            return false;
        }

        // Ensure email and backup email don't match
        if (email === backupEmail) {
            alert("Email and Backup Email cannot be the same.");
            return false;
        }

        // Check if passwords match
        if (password !== confirmPassword) {
            alert("Passwords do not match. Please try again.");
            return false;
        }

        var checkbox = document.getElementById("agreeEULA");
        if (!checkbox.checked) {
            alert("You must agree to the EULA before signing up.");
            return false;
        }
        return true;
    }
</script>

<?php include 'navbar.php'; ?>

<div class="signup-container">
    <h2 class="signup-title">Sign Up</h2>
    <form action="signup_process.php" method="post" onsubmit="return validateForm();">
        <div class="signup-form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="signup-form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="signup-form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="signup-form-group">
            <label for="backup">Backup Email:</label>
            <input type="email" id="backup" name="backup" required>
        </div>
        <div class="signup-form-group">
            <label for="first">First Name:</label>
            <input type="text" id="first" name="first" required>
        </div>
        <div class="signup-form-group">
            <label for="last">Last Name:</label>
            <input type="text" id="last" name="last" required>
        </div>
        <div class="login-form-group remember-me">
            <label class="remember-label" for="remember">Show Password</label>
            <input class="remember-me-checkbox" type="checkbox" id="showpassword" name="showpassword" onclick="showPassword()">
        </div>

        <!-- EULA Agreement Section -->
        <div class="login-form-group remember-me">
            <label for="agreeEULA">
                I agree to the <a href="EULA.txt" target="_blank">End User License Agreement</a>
            </label>
            <input class="remember-me-checkbox" type="checkbox" id="agreeEULA" name="agreeEULA">
        </div>

        <button type="submit" class="signup-btn">Sign Up</button>
    </form>
</div>
</body>
</html>
