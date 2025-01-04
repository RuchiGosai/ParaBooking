<?php
include 'config.php';
session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}

$user_id = $_GET['id'];
if (!$user_id) {
    echo "No user ID provided.";
    exit();
}

// This is a placeholder for actual postponement logic
// For now, we'll simply echo a message and redirect
echo "User with ID " . htmlspecialchars($user_id) . " has been postponed.";

header("Location: user_management.php");
exit();
?>
