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
    $email = $_POST['email'];
    $fullname = $_POST['full_name'];
    $phone = $_POST['phone_number'];

    $sql = "INSERT INTO users (username, password, email, full_name, phone_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $password, $email, $fullname, $phone);

    if ($stmt->execute()) {
        echo "New record created successfully";
        header('Location: thank_you.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(to right, #a8e6cf, #dcedc1);
        }

        .login-form h2 {
            margin-bottom: 20px;
            color: white;
            font-weight: bolder;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: burlywood;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid transparent;
            border-bottom: 2px solid #007BFF;
            background: transparent;
            color: white;
            border-radius: 0;
            box-sizing: border-box;
            outline: none;
            transition: border-bottom-color 0.3s;
        }

        .form-group input:focus {
            border-bottom-color: #0056b3;
        }

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

        button:hover {
            background-color: #0056b3;
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

        .container {
            background: url(images/sarina.jpg) no-repeat center center;
            background-size: cover;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            position: relative;
            backdrop-filter: blur(10px);
        }
    </style>
    <script>
        function exit() {
            window.location.href = "login1.php";
        }

        function validateForm() {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var email = document.getElementById('email').value;
            var fullname = document.getElementById('full_name').value;
            var phone = document.getElementById('phone_number').value;

            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            var phonePattern = /^[0-9]{10}$/;
            var namePattern = /^[A-Za-z\s]+$/;

            if (username.trim() == "" || username.length < 3) {
                alert("Username must be at least 3 characters long");
                return false;
            }
            if (password.trim() == "" || password.length < 5) {
                alert("Password must be at least 5 characters long");
                return false;
            }
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address");
                return false;
            }
            if (fullname.trim() == "" || fullname.length < 3) {
                alert("Full name must be at least 3 characters long");
                return false;
            }
            if (!namePattern.test(fullname)) {
                alert("Full name must not contain numbers");
                return false;
            }
            if (!phonePattern.test(phone)) {
                alert("Please enter a valid 10-digit phone number");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <button class="exit-button" onclick="exit()"></button>
        <form class="form-group" action="signIn.php" method="POST" onsubmit="return validateForm()">
            <h2>Sign In</h2>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" id="phone_number" name="phone_number" required>
            </div>
            <button type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>
