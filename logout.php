<?php
session_start();

// Destroy all session data
 $username= $_SESSION['username'];

session_destroy();

// Redirect to the login page
header("Location: testing.php");
exit();
?>