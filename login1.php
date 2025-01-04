<?php
session_start();
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "booking";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, set session variables
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        if ($row['user_role'] == 'admin') {
            header('Location:admin.php');
            echo "Login successful!";
        } else if ($row['user_role'] == 'user') {
            header('Location:Client_dash.php');
        }
    } else {
        echo "Invalid username or password.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style1.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(to right, #a8e6cf, #dcedc1);        }

        /* Form Heading */
        .login-form h2 {
            margin-bottom: 20px;
            color:white;
            font-weight: bolder;

        }

        /* Form Group for Label and Input */
        .form-group {
            margin-bottom: 15px;
        }

        /* Label Styles */
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: burlywood;
            font-weight: bold;
        }

        /* Input Field Styles */
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid transparent;
            border-bottom: 2px solid #007BFF; /* Highlighting border */
            background: transparent;
            color: white;
            border-radius: 0;
            box-sizing: border-box;
            outline: none;
            transition: border-bottom-color 0.3s;
        }

        .form-group input:focus {
            border-bottom-color: #0056b3; /* Darker blue on focus */
        }

        /* Button Styles */
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        /* Button Hover Effect */
        button:hover {
            background-color: #0056b3;
        }

        .links {
            margin-top: 20px;
        }

        .links a {
            margin-right: 10px;
            text-decoration: none;
            color: white;
        }

        .links a:hover {
            text-decoration: underline;
        }
        .exit-button {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            width: 30px;
            height: 30px;
            background-color: blue;
            border: none;
            font-size: 20px;
            line-height: 1;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            border-radius: 50%;
        }
        .exit-button::before {
            content: "\00d7";
        }

        .login-container {
            background: url(images/sarina.jpg) no-repeat center center;
            background-size: cover;
            background-color: rgba(255, 255, 255, 0.8); /* Transparent white overlay */
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            position: relative;
            backdrop-filter: blur(10px); /* Optional: adds a blur effect to the background */
        }
    </style>
    <script>
        function exit() {
            window.location.href = "testing.php";
        }
        function validateForm() {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;

            if (username.trim() == "" || username.length < 3) {
                alert("Username must be at least 3 characters long");
                return false;
            }
            if (password.trim() == "" || password.length < 5) {
                alert("Password must be at least 5 characters long");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="login-container">
    <button class="exit-button" onclick="exit()"></button>

        <form class="login-form" method="POST" action="" onsubmit="return validateForm()">
            <h2>LOGIN</h2>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="username" required maxlength="20" autocomplete="off">
            </div><br>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required maxlength="10">
            </div>
            <button type="submit">Login</button><br>
            <div class="links">
                <a href="forgot_password.php">Forgot Password?</a>
                <a href="signIn.php">Sign in?</a>
            </div>
        </form>
    </div>
</body>
</html>


