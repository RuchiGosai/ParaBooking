<?php
// Include database configuration and start session
include('config.php');
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login1.php");
    exit();
}

// Fetch user data based on session username
$user1 = $_SESSION['username'];
$sql1 = "SELECT username, email, phone_number FROM users WHERE username = '$user1'";
$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $username = $user['username'];
    $email = $user['email'];
}

// Initialize alert messages and redirection flag
$success_message = '';
$error_message = '';
$redirect_url = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get booking date and time
    $date = $_POST['date'];
    $time = $_POST['time'];
    
    // Sanitize and validate inputs (ensure proper validation as per your application's requirements)
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Insert booking information into booking_info table
    $sql = "INSERT INTO booking_info (username, email, booking_date, booking_time, status)
            VALUES ('$username', '$email', '$date', '$time', 'pending')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Booking successfully recorded.";
        $redirect_url = "my_bookings.php"; // Redirect to My Bookings page upon success
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();

// Perform redirection if $redirect_url is set
if (!empty($redirect_url)) {
    header("Location: $redirect_url");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking Form</title>
    <style>
        /* Basic CSS styling for the form */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 20px;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: auto;
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type=text], input[type=email], input[type=tel], input[type=date], input[type=time] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
        }
        .success {
            color: green;
            font-size: 16px;
        }
        .my-bookings-link {
            text-align: center;
            margin-top: 20px;
        }
        .my-bookings-link a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Flight Booking Form</h2>
        <?php
        // Display success or error message if set
        if (!empty($success_message)) {
            echo '<div class="success">' . $success_message . '</div>';
            // Display link to My Bookings page upon success
            echo '<div class="my-bookings-link"><a href="my_bookings.php">Go to My Bookings</a></div>';
        }
        if (!empty($error_message)) {
            echo '<div class="error">' . $error_message . '</div>';
        }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <select id="time" name="time" required>
                    <option value="10:00">10:00 AM</option>
                    <option value="12:30">12:30 PM</option>
                    <option value="15:00">3:00 PM</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Book Flight">
            </div>
        </form>
    </div>
</body>
</html>
