<?php
include('config.php');
session_start();

$un = $_SESSION['username'];

if (!$un) {
    header("Location:login1.php");
}
// Check if the form is submitted
if (isset($_POST['own_changepassword'])) {
    // $username = $_POST['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    // Check if the username exists in the database
    $sql = "SELECT * FROM users WHERE username = '$un'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Username exists, update the password
        $sql_update = "UPDATE users SET password = '$new_password' WHERE username = '$un' AND password = '$old_password'";
        if ($conn->query($sql_update) === TRUE) {
            echo "<script>
            alert('Password changed successfully');
            window.location.href = 'admin.php';
          </script>";
            exit;
        } else {
            echo "<script>
            alert('Error updating password: " . $conn->error . "');
            window.location.href = 'own_changepassword.php';
          </script>";
            exit;
        }
    } else {
        echo "<script>
        alert('Username not found.');
        window.location.href = 'own_changepassword.php';
      </script>";
        exit;
    }
}

// Close the database connection
$conn->close();
?>
