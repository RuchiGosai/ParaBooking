<?php
include ('config.php');
session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bookings</title>
    <style>
        body {
            display: flex;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: url(images/p1.jpg) no-repeat center center fixed; /* Background image */
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
        .add-pilot-button {
            background-color: #73AD21;
            color: white; /* Optional: makes text more readable */
            border: none; /* Optional: removes border */
            padding: 10px 20px; /* Optional: adds padding */
            cursor: pointer; /* Optional: changes cursor to pointer on hover */
        }

        .add-pilot-button:hover {
            background-color: #5c8b17;
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

        .styled-table {
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .styled-table thead tr {
            color:black;
            text-align: center;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            border: 1px solid #ccc;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
            /* background-color: #f3f3f3; */
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
        h2 {
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }
        .status-button {
    background-color: #007BFF; 
    color: white; 
    border: none; 
    padding: 10px 20px; 
    cursor: pointer; 
    border-radius: 5px; 
}

.status-button:hover {
    background-color: #0056b3; 
}

        .cancel-button {
    background-color: #FF0000; 
    color: white;
    border: none; 
    padding: 10px 20px; 
    cursor: pointer; 
    border-radius: 5px; 
}

.cancel-button:hover {
    background-color: #CC0000;
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
        <h2>Pending Bookings </h2>
        <?php
        $result = $conn->query("SELECT * FROM booking_info WHERE status='pending'");
        if ($result->num_rows > 0) {
            echo "<table class='styled-table'>";
            echo "<thead><tr>
            <th>Booking ID</th>
            <th>Username</th>
            <th>Booking Date</th>
            <th>Booking Time</th>
            <th>Status</th>
            <th>Actions</th></tr>
            </thead>";
            echo "<tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["booking_id"]. "</td>";
                echo "<td>" . $row["username"]. "</td>";
                echo "<td>" . $row["booking_date"]. "</td>";
                echo "<td>" . $row["booking_time"]. "</td>";
                echo "<td><input type='button' class='status-button' onclick=\"redirectToNewPage('" . $row["username"] . "')\" value='" . htmlspecialchars($row['status']) . "'></td>";
                echo "<td><button class='cancel-button' onclick=\"cancelBooking(" . $row['booking_id'] . ")\">Cancel</button></td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "0 results";
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
            window.location.href = "logout.php"; 
        }

        function changePassword() {
            window.location.href = "own_changepassword.php"; 
        }

        function redirectToNewPage(username) {
            window.location.href = "Assigned_pilot.php?username=" + encodeURIComponent(username);
        }

        function cancelBooking(bookingId) {
            if (confirm("Are you sure you want to cancel this booking?")) {
                window.location.href = "cancel_booking.php?booking_id=" + bookingId;
            }
        }
    </script>
</body>
</html>
