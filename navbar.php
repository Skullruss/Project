<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session only if not already started
}

include 'config.php'; // Include database configuration if needed
?>

<nav class="navbar">
    <ul>
        <li><a href="<?php echo $base_url; ?>">Home</a></li>
        <li><a href="<?php echo $base_url; ?>/portfolio">Portfolio</a></li>
        <li><a href="<?php echo $base_url; ?>/sheets">Sheets</a></li>
        <li><a href="<?php echo $base_url; ?>/contact">Contact Us</a></li>
        <li><a href="<?php echo $base_url; ?>/about">About Us</a></li>
        <?php if (isset($_SESSION['email'])): ?>
            <li><a href="logout.php" class="navbar-link">Logout</a></li>
        <?php else: ?>
            <li><a href="<?php echo $base_url; ?>/login" class="navbar-link">Login</a></li>
        <?php endif; ?>
        <!-- <li><a href="<?php echo $base_url; ?>/signup">Signup</a></li> -->
    </ul>
</nav>
