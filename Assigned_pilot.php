<?php
include('config.php');
session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}

// Fetch employees
$employees_result = $conn->query("SELECT employee_id, employee_name FROM employees");

// Fetch bookings
$bookings_result = $conn->query("SELECT booking_id, username FROM booking_info");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        body {
            display: flex;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: url(images/p1.jpg) no-repeat center center fixed;
            /* Background image */
            background-size: cover;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: rgba(179, 229, 252, 0.8);
            /* Transparent light blue gradient */
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
            background-color: #5c8b17;
            /* Slightly darker shade on hover */
        }

        .container {
            margin: auto;
            width: 50%;
            border: 3px solid #73AD21;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: rgba(223, 255, 214, 0.8);
            /* Transparent light pastel green */
            border-radius: 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .sidebar {
            width: 200px;
            background-color: rgba(179, 229, 252, 0.8);
            /* Transparent light blue gradient */
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

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background-color: #62b3f5;
        }

        .sidebar ul li a:last-child {
            color: black;
            font-weight: bold;
        }

        input[type="submit"] {
            background-color: #73AD21;
            /* Darker green */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #5c8b17;
            /* Slightly darker shade on hover */
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
    
    <div class="footer">
        Logged in as <span id="username"><?php echo htmlspecialchars($un); ?></span>
        <button onclick="logout()">Logout</button>
        <button onclick="changePassword()">Change Password</button>
    </div>
    <div class="container">
        <h1>Assign Booking To Employees</h1>
        <form action="assign_booking.php" method="post">
            <label for="employee">Select Employee:</label>
            <select name="employee_id" id="employee" required>
                <?php
                // Query to fetch employee IDs from employee_bookings table
                $employee_query = "SELECT e.employee_id
FROM employees e
LEFT JOIN employee_bookings eb ON e.employee_id = eb.employee_id
GROUP BY e.employee_id
HAVING COUNT(CASE WHEN eb.booking_date = CURDATE() THEN eb.booking_date END) < 3 OR
 COUNT(CASE WHEN eb.booking_date = CURDATE() THEN eb.booking_date END) IS NULL;";
                $employee_result = $conn->query($employee_query);

                // Fetch and display employee names
                while ($employee = $employee_result->fetch_assoc()) :
                    // Fetch employee details based on employee_id
                    $employee_details_query = "SELECT employee_name FROM employees WHERE employee_id = '{$employee['employee_id']}'";
                    $employee_details_result = $conn->query($employee_details_query);
                    $employee_details = $employee_details_result->fetch_assoc();
                ?>
                    <option value= "<?php echo htmlspecialchars($employee['employee_id']); ?>">
                        <?php echo htmlspecialchars($employee_details['employee_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <br><br>
            <label for="booking">Select Booking:</label>
            <select name="booking_id" id="booking" required>
                <?php
                // Query to fetch pending bookings
                $bookings_result = $conn->query("SELECT booking_id, username FROM booking_info where status='pending'");

                $selected_username = isset($_GET['selected_username']) ? $_GET['selected_username'] : '';
                while ($booking = $bookings_result->fetch_assoc()) : ?>
                    <?php if ($booking['username'] === $selected_username) : ?>
                        <option value="<?php echo htmlspecialchars($booking['booking_id']); ?>" selected>
                            <?php echo htmlspecialchars($booking['username'] . " (ID: " . $booking['booking_id'] . ")"); ?>
                        </option>
                    <?php else : ?>
                        <option value="<?php echo htmlspecialchars($booking['booking_id']); ?>">
                            <?php echo htmlspecialchars($booking['username'] . " (ID: " . $booking['booking_id'] . ")"); ?>
                        </option>
                    <?php endif; ?>
                <?php endwhile; ?>
            </select>
            <br><br>
            <input type="submit" value="Assign Booking">
        </form>
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