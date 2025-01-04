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

// Delete the user
$sql = "DELETE FROM users WHERE id = $user_id";

if ($conn->query($sql) === TRUE) {
    echo "User has been cancelled (deleted) successfully.";
} else {
    echo "Error cancelling user: " . $conn->error;
}

$conn->close();

header("Location: user_management.php");
exit();
?>
