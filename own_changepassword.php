<?php
include('config.php');
session_start();

$un = $_SESSION['username'];

if (!$un) {
    header("Location:login1.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>changing password</title>
    <style>
        label{
            font-weight: bold;
        }
    </style>

<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            flex-grow: 1;
        
            justify-content: center;
            align-items: center;
            background-color: #f7f7f7;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #de1f26;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: auto;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #de1f26;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #ff4d4d;
        }

        .footer {
            background: #de1f26;
            color: #fff;
            padding: 10px;
            text-align: center;
            width: 100%;
        }

        .footer button {
            background-color: #FFD700;
            color: #333;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            margin-right: 10px;
            border-radius: 4px;
        }

        .footer button:hover {
            background-color: #FFA500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Change Password</h1>
    <form id="changePasswordForm" action="changepassword.php" method="post">
        <label for="old_password">Old Password:</label>
        <input type="password" id="old_password" name="old_password" required><br><br>

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required><br><br>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

                <input type="submit" name="own_changepassword" value="Change Password">
    </form>

    <script>
        document.getElementById("changePasswordForm").onsubmit = function() {
            var newPassword = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (newPassword !== confirmPassword) {
                alert("New passwords do not match. Please enter them again.");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        };
    </script>
    </div>
    
</body>


</html>
