<?php
include ('config.php');
session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}

// Get the logged-in user's username from the session
$logged_in_username = $_SESSION['username'];

// Fetch user information
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $logged_in_username);
$stmt->execute();
$result = $stmt->get_result();

// if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
// } else {
//     echo "No user found.";
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['username'];
    $email = $_POST['email'];

    // Update user information
    $update_sql = "UPDATE users SET username = ?, email = ? WHERE username = ? OR email = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssss", $name, $email, $logged_in_username, $logged_in_username);

    if ($update_stmt->execute() == TRUE) {
        echo "<script type='text/javascript'>
                alert('Record updated successfully');
                window.location.href = window.location.href;
              </script>";
        // Refresh user data
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $update_stmt->close();
}

$stmt->close();


// for count
$username= "Ram";
$sql = "
SELECT e.employee_id, e.employee_name,  COUNT(b.booking_id) AS booking_count
FROM employee_bookings eb
JOIN employees e ON eb.employee_id = e.employee_id
JOIN booking_info b ON eb.booking_id = b.booking_id
WHERE e.employee_name = ?
GROUP BY e.employee_id, e.employee_name
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$employee = null;

if ($result->num_rows > 0) {
    $employee = $result->fetch_assoc();
} else {
    echo "No bookings found for this employee.";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilot Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
           display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: #62b3f5;
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
        h2 {
         border-bottom: 2px solid #ccc;
        padding-bottom: 10px;
}

        .sidebar ul li a:last-child {
            color: black;
            font-weight: bold;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            margin-top: 10px;
            padding: 10px 15px;
        }
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #62b3f5;
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
            <li><a href="pilot_info.php">My Profile</a></li>
            <li><a href="my_Clients.php">My Clients</a></li>
  
        </ul>
    </div>
    <div class="container">
        <h2>Pilot Profile</h2>
        <p>Logged in as: <?php echo htmlspecialchars($logged_in_username); ?></p>
        <form method="POST" action="">
            <label for="username">Total flight taken:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($employee['booking_count']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <button type="submit">Save</button>
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
</body>
</html>
