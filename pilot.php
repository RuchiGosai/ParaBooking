<?php
include('config.php');
session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilot Dashboard</title>
    <link rel="stylesheet" href="style2.css">
     <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color:  #62b3f5;
            color: black;
            padding: 10px;
            text-align: center;
        }

        .footer button {
            background-color: #575757;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            margin-right: 10px;
        }
    </style> 
</head>
<body>
    <div class="sidebar">
        <h2>Pilot Dashboard</h2>
        <ul>
            <li><a href="pilot_info.php">My profile</a></li>
            <li><a href="my_Clients.php">My Clients</a></li>
        </ul>
    </div>
       <div class="main-content">
        <div id="user_info-section" class="content-section">
            <h2>User Info</h2>
            <p>Manage users information here.</p>
        </div>
        
   
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
