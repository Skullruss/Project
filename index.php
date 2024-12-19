<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
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


    <h1 class="text-center page-title">Welcome to Alchemic Arts</h1>
    <hr>
</body>

</html>