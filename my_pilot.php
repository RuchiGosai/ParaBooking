<?php
include('config.php');
session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}

// Fetch details of employees assigned to the logged-in user's bookings
$sql = "
    SELECT 
        b.booking_id, 
        b.booking_date, 
        b.booking_time, 
        b.status,
        e.employee_name,
        e.contact, 
        e.email AS employee_email
    FROM 
        booking_info b
    LEFT JOIN 
        employee_bookings eb ON b.booking_id = eb.booking_id
    LEFT JOIN 
        employees e ON eb.employee_id = e.employee_id
    WHERE 
        b.username = '$un'
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .container {
            width: 100%;
            height: 100vh;
            position: relative;
        }

        .background-clip {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .sidebar {
            width: 200px;
            background-color: rgba(139, 69, 19, 0.3); /* Transparent light brown */
            color: whitesmoke;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            z-index: 1;
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

             .container1 {
    margin: 50px auto; /* Center the container horizontally with margin-top for spacing */
    padding: 20px;
    border: black;
    width: calc(60% - 220px); /* Adjusted width calculation to center-align */
    background-color: rgba(173, 216, 230, 0.6); /* Light background with transparency */
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle box shadow */
    text-align: center; /* Center-align the text */
    max-height: 40vh; /* Maximum height of 40% of viewport height */
    overflow-y: auto; /* Enable vertical scroll if content exceeds max-height */
}

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: rgba(139, 69, 19, 0.3);
            color: white;
            padding: 10px;
            text-align: center;
            z-index: 1;
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
            background-color: #5d8c1a;
        }
    </style>
</head>
<body>
<div class="container">
    <video autoplay loop muted plays-inline class="background-clip">
        <source src="videos/PV1.mp4" type="video/mp4">
    </video>
    <div class="sidebar">
        <h2>Client Dashboard</h2>
        <ul>
            <li><a href="client_profile.php">My Profile</a></li>
            <li><a href="my_bookings.php">My Bookings</a></li>
            <li><a href="my_pilot.php">My Pilot</a></li>
        </ul>
    </div>
    <div class="container1">
        <h2>My Bookings</h2>
        <?php 
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['status'] == 'confirmed') {
                echo "<form>
                        <label for='field1'>Booking Time:</label>
                        <input type='time' id='field1' name='field1' readonly value='" . htmlspecialchars($row['booking_time']) . "'><br><br>

                        <label for='field2'>Booking Date:</label>
                        <input type='date' id='field2' name='field2' readonly value='" . htmlspecialchars($row['booking_date']) . "'><br><br>

                        <label for='employee_name'>Assigned Pilot:</label>
                        <input type='text' id='employee_name' name='employee_name' readonly value='" . htmlspecialchars($row['employee_name']) . "'><br><br>

                        <label for='employee_email'>Pilot Email:</label>
                        <input type='text' id='employee_email' name='employee_email' readonly value='" . htmlspecialchars($row['employee_email']) . "'><br><br>

                        <label for='employee_contact'>Pilot Contact:</label>
                        <input type='text' id='employee_contact' name='employee_contact' readonly value='" . htmlspecialchars($row['contact']) . "'><br><br>
                    </form>";
            } elseif ($row['status'] == 'cancelled') {
                echo "<h3>Your booking has been cancelled.</h3>";
            } else {
                echo "<h3>Your booking is pending</h3><br>";
                echo "<h3>You have not been assigned with pilot</h3>";
            }
        } else {
            echo "<h3>No bookings found</h3>";
        }
        $conn->close();
        ?>
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
