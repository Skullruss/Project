<?php
session_start();
require 'config.php'; // Database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember']); // Check if "Remember Me" is checked

    // Query the database for the user's hashed password and salt
    $stmt = $conn->prepare("SELECT userid, password, salt FROM dat_user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password, $salt);
        $stmt->fetch();
        
        // Verify the password by hashing it with the stored salt
        $password_check = hash('sha256', $password . $salt);
        
        if ($password_check === $hashed_password) {
            // Handle the "Remember Me" feature
            if ($remember_me) {
                // Set cookies to remember user login for 30 days
                $cookie_time = time() + (86400 * 30); // 86400 = 1 day
                setcookie("email", $email, $cookie_time, "/");
                setcookie("user_id", $user_id, $cookie_time, "/");

                // Set session cookie to last for 30 days
                session_set_cookie_params(86400 * 30); // 30 days
            } else {
                // Set session cookie to last for 24 hours
                session_set_cookie_params(86400); // 1 day
            }

            // Start session and set session variables
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $user_id;

            // Send the survey email
            $subject = "We Value Your Feedback!";
            $message = "
                <html>
                <head>
                    <title>We Value Your Feedback</title>
                </head>
                <body>
                    <p>At Alchemic-Arts, we take your opinions seriously. Please take the following survey to give us feedback:</p>
                    <p><a href='https://forms.gle/VJgE86EKTKMMLpye6'>Take the Survey</a></p>
                    <p>Thank you for helping us improve!</p>
                </body>
                </html>
            ";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: no-reply@alchemic-arts.com" . "\r\n";

            // if (mail($email, $subject, $message, $headers)) {
            //     echo "Survey email sent successfully.";
            // } else {
            //     echo "Failed to send the survey email.";
            // }

            // Redirect to the main page after the survey email is sent
            header("Location: index.php");
            exit;
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
