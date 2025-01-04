<?php
include 'config.php';
session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: user_management.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
} else {
    header("Location: user_management.php");
    
    exit();
}

$conn->close();
?>
