<?php
session_start();

if (!isset($_SESSION['email']) && isset($_COOKIE['email']) && isset($_COOKIE['user_id'])) {
    // Auto-login using cookies
    $_SESSION['email'] = $_COOKIE['email'];
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    // Optionally, redirect or allow them to continue on the current page
}
?>