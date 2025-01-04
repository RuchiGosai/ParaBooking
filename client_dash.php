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
    <title>Client Dashboard</title>
    <!-- <link rel="stylesheet" href="style2.css"> -->
     <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
}
.container{
    width: 100%;
    height: 100vh;
    background-color: #ccc;
}

@media(min-aspect-ratio:16/9){
    .background-clip{
        width: 100%;
        height: auto;
    }
}
@media(max-aspect-ratio:16/9){
    .background-clip{
        width: auto;
        height: 100%;
    }
}
.footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: rgba(139, 69, 19, 0.3); /* Transparent light brown */
    color: white;
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
    background-color: #5d8c1a; /* Slightly darker shade on hover */
}

.sidebar {
    width: 200px;
    background-color: rgba(139, 69, 19, 0.3); /* Transparent light brown */
    color: whitesmoke;
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
    color: wheat;
    text-decoration: none;
    display: block;
    padding: 10px;
}

.sidebar ul li a:hover, .sidebar ul li a.active {
    background-color: #62b3f5;
}

.sidebar ul li a:last-child {
    color: wheat;
    font-weight: bold;
}

h2 {
    border-bottom: 2px solid #ccc;
    padding-bottom: 10px;
}
    

.welcome-container {
            text-align: center;
            font-size: 48px;
            font-weight: bold;
            color: lightgoldenrodyellow;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style> 
</head>
<body>
    <div class="container">
        <video autoplay loop muted plays-inline class="background-clip">
            <source src="videos/PV1.mp4" type="video/mp4">
        </video>
    </div>
    <div class="welcome-container">
        WELCOME TO THE USER'S DASHBOARD
    </div>
    <div class="sidebar">
        <h2>Client Dashboard</h2>
        <ul>

            <li><a href="client_profile.php">My Profile</a></li>
            <li><a href="my_bookings.php">My bookings</a></li>
            <li> <a href="my_pilot.php"> My pilot</li>
        </ul>
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
