<?php
include('config.php');
session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}

// Fetch bookings for the logged-in user
$sql = "SELECT booking_id, booking_date, booking_time, status FROM booking_info WHERE username='$un'";
$result = $conn->query($sql);

// Handle the update booking request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_booking'])) {
    $booking_id = $_POST['booking_id'];
    $new_date = $_POST['new_date'];
    $new_time = $_POST['new_time'];

    // Validate new date and time
    $current_date = date('Y-m-d');
    if ($new_date < $current_date) {
        $error_message = "The booking date cannot be in the past.";
    } else {
        $update_sql = "UPDATE booking_info SET booking_date='$new_date', booking_time='$new_time' WHERE booking_id='$booking_id' AND username='$un'";
        if ($conn->query($update_sql) === TRUE) {
            header("Location: my_bookings.php?message=Booking updated successfully");
            exit();
        } else {
            $error_message = "Error updating record: " . $conn->error;
        }
    }
}
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
            height: 100vh;
            overflow: hidden;
        }

        .container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .background-clip {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar {
            width: 200px;
            background-color: rgba(139, 69, 19, 0.3);
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

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
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
            margin: 50px auto;
            padding: 20px;
            width: calc(60% - 220px);
            background-color: rgba(173, 216, 230, 0.6);
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-height: 40vh;
            overflow-y: auto;
        }

        .message {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
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

        .input-box {
            width: calc(40% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #101bb4;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 5px;

        }

        button[type="submit"]:hover {
            background-color: #11136e;
        }

        button[type="button"] {
            background-color: #101bb4;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 5px;
        }

        button[type="button"]:hover {
            background-color: #11136e;
        }


        .error {
            color: red;
            margin-bottom: 20px;
        }

        a {
            color: #de1f26;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <video autoplay loop muted plays-inline class="background-clip">
            <source src="videos/PV1.mp4" type="video/mp4">
        </video>
    </div>
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
        if (isset($_GET['message'])) {
            echo "<div class='message'>" . htmlspecialchars($_GET['message']) . "</div>";
        }

        if (isset($error_message)) {
            echo "<div class='error'>" . htmlspecialchars($error_message) . "</div>";
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['status'] == 'confirmed') {
                    echo "<h3>Your booking is confirmed.</h3><br>";
                    echo "<form>
                        <label for='field1'>Booking Time:</label>
                        <input type='time' id='field1' class='input-box' name='field1' readonly value='" . htmlspecialchars($row['booking_time']) . "'><br><br>

                        <label for='field2'>Booking Date:</label>
                        <input type='date' id='field2' class='input-box' name='field2' readonly value='" . htmlspecialchars($row['booking_date']) . "'><br><br>
                      </form>";
                } else if ($row['status'] == 'cancelled') {
                    echo "<h3>Your booking has been cancelled.</h3>";
                    echo "<a href='book_flight.php'>Book your flight again</a>";
                    break;
                } else {
                    echo "<h3>Your booking is pending</h3>";
                    echo "<form method='post'>
                        <label for='field1'>Booking Time:</label>
                        <input type='time' id='field1' class='input-box' name='field1' readonly value='" . htmlspecialchars($row['booking_time']) . "'><br><br>

                        <label for='field2'>Booking Date:</label>
                        <input type='date' id='field2' class='input-box' name='field2' readonly value='" . htmlspecialchars($row['booking_date']) . "'><br><br>

                        <button type='button' onclick='showUpdateForm()'>Update Booking</button>

                        <div id='updateForm' style='display:none; margin-top:20px;'>
                            <h4>Update Booking</h4>
                            <input type='hidden' name='booking_id' value='" . htmlspecialchars($row['booking_id']) . "'>
                            <label for='new_date'>New Date:</label>
                            <input type='date' id='new_date' class='input-box' name='new_date' required><br><br>
                            <label for='new_time'>New Time:</label>
                            <select id='new_time' class='input-box' name='new_time' required>
                                <option value='10:00'>10:00 AM</option>
                                <option value='12:30'>12:30 PM</option>
                                <option value='15:00'>3:00 PM</option>
                            </select><br><br>
                            <button type='submit' name='update_booking'>Save Changes</button>
                        </div>
                      </form>";
                    break;
                }
            }
        } else {
            echo "<h3>No bookings found</h3>";
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
        function showUpdateForm() {
            document.getElementById('updateForm').style.display = 'block';
        }

        function logout() {
            window.location.href = "logout.php";
        }

        function changePassword() {
            window.location.href = "own_changepassword.php";
        }

        // Additional validation for the date input
        document.getElementById('new_date').addEventListener('change', function() {
            var selectedDate = new Date(this.value);
            var currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0); // Set the time part to 00:00:00 for comparison

            if (selectedDate < currentDate) {
                alert('The booking date cannot be in the past.');
                this.value = '';
            }
        });
    </script>
</body>

</html>