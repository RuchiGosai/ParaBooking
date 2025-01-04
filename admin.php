<?php
include('config.php');
session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1..php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- <link rel="stylesheet" href="style2.css"> -->
     <style>
         .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: rgba(179, 229, 252, 0.8); /* Transparent light blue gradient */
            color: black;
            padding: 10px;
            text-align: center;
        }

        .footer button {
            background-color: #73AD21;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            margin-right: 10px;
        }
        .footer button:hover {
            background-color: #5c8b17; /* Slightly darker shade on hover */
        }
        body {
            display: flex;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: url(images/p1.jpg) no-repeat center center fixed;
            background-size: cover;
        }
        .sidebar {
            width: 200px;
            background-color: rgba(179, 229, 252, 0.8); /* Transparent light blue gradient */
            color: black;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 10px 20px;
        }

        .sidebar ul li a {
            color: black;
            text-decoration: none;
            display: block;
            padding: 10px;
        }

        .sidebar ul li a:hover, .sidebar ul li a.active {
            background-color: #62b3f5;
        }

        .sidebar ul li a:last-child {
            color: black;
            font-weight: bold;
        }
        .welcome-container {
            text-align: center;
            font-size: 48px;
            font-weight: bold;
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style> 
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="user_management.php">User Management</a></li>
            <li><a href="employee_management.php">Employee Management</a></li>
            <li><a href="booking.php">Booking</a></li>
            <li><a href="Assigned_pilot.php">Assigned Pilot</a></li>
            <li><a href="reports.php">Reports</a></li>
        </ul>
    </div>
    
    </div>
     <div class="welcome-container">
        WELCOME TO THE ADMIN DASHBOARD
    </div>
    <div class="footer">
        Logged in as <span id="username"><?php echo htmlspecialchars($un); ?></span>
        <button onclick="logout()">Logout</button>
        <button onclick="changePassword()">Change Password</button>
    </div>

    <script>
        function logout() {
            window.location.href = "logout.php"; 
        }

        function changePassword() {
            window.location.href = "own_changepassword.php"; 
        }
    </script>
    
</body>
</html>
