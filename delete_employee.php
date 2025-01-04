<?php
include 'config.php';
session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}

if (isset($_GET['employee_id'])) {
    $employee_id = intval($_GET['employee_id']);
    $stmt = $conn->prepare("DELETE FROM employees WHERE employee_id = ?");
    $stmt->bind_param("i", $employee_id);
    
    if ($stmt->execute()) {
        header("Location: employee_management.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
} else {
    header("Location: employee_management.php");
    
    exit();
}

$conn->close();
?>
