<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style1.css">
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

        .login-container {
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

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #f44336;
            color: white;
            padding: 10px;
            border-radius: 5px;
            z-index: 1000;
        }
    </style>
    <script>
        function showAlert(message) {
            const alertBox = document.createElement('div');
            alertBox.textContent = message;
            alertBox.className = 'alert';
            document.body.appendChild(alertBox);

            setTimeout(() => {
                alertBox.remove();
            }, 5000); // Show alert for 5 seconds
        }

        function exit() {
            window.location.href = "login1.php";
        }

        document.addEventListener('DOMContentLoaded', function() {
            <?php
            if (isset($_SESSION['message']) && $_SESSION['message'] !== '') {
                echo 'showAlert("' . $_SESSION['message'] . '");';
                unset($_SESSION['message']);
            }
            ?>
        });
    </script>
</head>
<body>
    <div class="login-container">
        <form class="login-form" method="POST" action="">
            <button class="exit-button" type="button" onclick="exit()"></button>
            <h2>Forgot Password</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" required minlength="5" maxlength="50" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="5" maxlength="50" autocomplete="off">
            </div>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
