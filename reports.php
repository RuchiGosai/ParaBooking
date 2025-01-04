<?php
include ('config.php');

session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}

// Fetch total number of bookings
$sqlBookings = "SELECT COUNT(*) AS total_bookings FROM booking_info";
$resultBookings = $conn->query($sqlBookings);

// Fetch total number of pilots
$sqlPilots = "SELECT COUNT(*) AS total_pilots FROM employees";
$resultPilots = $conn->query($sqlPilots);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
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

        .container {
            margin: auto;
            width: 50%;
            border: 3px solid #73AD21;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: rgba(223, 255, 214, 0.8); /* Transparent light pastel green */
            border-radius: 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        h1 {
            font-size: 30px;
            margin-bottom: 20px;
            color: black;
            padding: 10px;
            border-radius: 5px;
        }

        p {
            font-size: 24px;
            line-height: 2;
        }

        .total-bookings,
        .total-pilots {
            font-weight: bold;
            color: blue;
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
<div class="container">
    <h1>Admin Booking Report</h1>
    <?php
    if ($resultBookings && $resultBookings->num_rows > 0) {
        $rowBookings = $resultBookings->fetch_assoc();
        $total_bookings = $rowBookings['total_bookings'];
        echo "<p>The total number of bookings is: <span class='total-bookings'>" . htmlspecialchars($total_bookings) . "</span></p>";
    } else {
        echo "<p>No bookings found or query failed.</p>";
    }

    if ($resultPilots && $resultPilots->num_rows > 0) {
        $rowPilots = $resultPilots->fetch_assoc();
        $total_pilots = $rowPilots['total_pilots'];
        echo "<p>The total number of pilots is: <span class='total-pilots'>" . htmlspecialchars($total_pilots) . "</span></p>";
    } else {
        echo "<p>No pilots found or query failed.</p>";
    }

    $conn->close();
    ?>
</div>
<div class="footer">
    Logged in as <span id="username"><?php echo htmlspecialchars($un); ?></span>
    <button onclick="logout()">Logout</button>
    <button onclick="changePassword()">Change Password</button>
</div>
<script>
    function logout() {
        window.location.href = 'logout.php';
    }
    function changePassword() {
        window.location.href = 'change_password.php';
    }
</script>
</body>
</html>
