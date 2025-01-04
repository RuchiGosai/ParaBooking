<?php
// Start session
session_start();

// Include database connection
include 'config.php';
$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}

// Check if user is logged in
if(!isset($_SESSION['username'])) {
    header("Location: client_dash.php");
    exit();
}

// Fetch user data
$user1 = $_SESSION['username'];
$sql1 = "SELECT username, email, phone_number FROM users WHERE username = '$user1'";
$stmt = $conn->query($sql1);
if ($stmt->num_rows>0){
   $user = $stmt->fetch_assoc();
}

// Initialize alert messages
$success_message = '';
$error_message = '';

// Check if form is submitted

?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eef2f5;
            overflow: hidden; /* To ensure no scrollbars */
            height: 100vh;
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* To cover the entire viewport */
            z-index: -1; /* To place the video behind other elements */
        }

        .sidebar {
            width: 200px;
            background-color: rgba(139, 69, 19, 0.3); /* Transparent light brown */
            color: whitesmoke;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            z-index: 1; /* To keep it above the video */
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

        .main-content {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
            border: #333;
        }
        form {
    background-color: rgba(173, 216, 230, 0.6); /* Light blue with slight transparency */
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    margin: 20px auto;
}

form h2 {
    margin-top: 0;
    margin-bottom: 20px;
    color: #333;
}

form label {
    display: block;
    margin-bottom: 5px;
    color: #333; /* Darker text for contrast */
}

form input[type="text"], form input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

form input[type="submit"] {
    background-color: #73AD21; /* Sky blue */
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 3px;
}

form input[type="submit"]:hover {
    background-color:#5d8c1a ; /* Steel blue on hover */
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
            z-index: 1; /* To keep it above the video */
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
    </style>
</head>
<body>
    <video autoplay loop muted plays-inline class="video-background">
        <source src="videos/PV1.mp4" type="video/mp4">
    </video>

    <div class="sidebar">
        <h2>Client Dashboard</h2>
        <ul>
            <li><a href="client_profile.php">My Profile</a></li>
            <li><a href="my_bookings.php">My bookings</a></li>
            <li><a href="my_pilot.php">My Pilot</a></li>
        </ul>
    </div>

    <div class="main-content">
        <form method="POST" action="">
            <h2>Client Profile</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" readonly value="<?php echo htmlspecialchars($user['email']); ?>">

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone_number']); ?>">

            <input type="submit" value="Update Profile">
        </form>
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
    <?php
    if($success_message) {
        echo "<script>alert('$success_message');</script>";
    }
    if($error_message) {
        echo "<script>alert('$error_message');</script>";
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        
        // Update user data
        $sql = "UPDATE users SET username='$username', email='$email', phone_number='$phone' WHERE username= '$user1'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['username'] = $username;
            echo "<script>alert('Success'); window.location.href ='client_dash.php';</script>";
        } else {
            $error_message = "Error updating profile!";
            echo "<script>alert('$error_message');</script>";
        }
    }
    ?>
</body>
</html>
