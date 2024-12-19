<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your external CSS file -->
</head>

<body>
    <script>
        function showPassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

    <?php include 'navbar.php'; ?>

    <div class="login-container">
        <?php if (isset($_SESSION['email'])): ?>
            <h2 class="login-title">You are logged in as <?php echo htmlspecialchars($_SESSION['email']); ?></h2>
            <form action="logout.php" method="post">
                <button type="submit" class="login-btn">Logout</button>
            </form>
        <?php else: ?>
            <h2 class="login-title">Login</h2>
            <form action="login_process.php" method="post">
                <div class="login-form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="login-form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="login-form-group remember-me">
                    <label class="remember-label" for="remember">Show Password</label>
                    <input class="remember-me-checkbox" type="checkbox" id="showpassword" name="showpassword"  onclick="showPassword()">
                </div>

                <div class="login-form-group remember-me">
                    <label class="remember-label" for="remember">Remain Logged In</label>
                    <input class="remember-me-checkbox" type="checkbox" id="remember" name="remember">
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>
            <div class="login-links">
                <a href="signup.php" class="login-link-btn">Sign Up</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>