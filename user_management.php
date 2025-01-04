<?php
include ('config.php');
session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}

// Fetch all users
$result = $conn->query("SELECT * FROM users");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .main-content {
            flex: 1;
            padding: 20px;
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
        h2{
    border-bottom: 2px solid #ccc;
    padding-bottom: 10px;
}

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
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
        <h2>User Management</h2>
        <table>
            <tr><th>User_id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>";
                echo "<a href='delete_user.php?id=" . htmlspecialchars($row['id']) . "'>Delete</a> ";
                // echo "<a href='cancel_user.php?id=" . htmlspecialchars($row['id']) . "'> Cancel</a>";
               
                echo "</td>";
                echo "</tr>";
            }
            $conn->close();
            ?>
        </table>
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
