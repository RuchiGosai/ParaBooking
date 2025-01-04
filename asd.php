<?php
include('config.php');

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
    <title>Assign Booking to Employee</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Assign Booking to Employee</h1>
        <form action="assign_booking.php" method="post">
            <label for="employee">Select Employee:</label>
            <select name="employee_id" id="employee" required>
                <?php while ($employee = $employees_result->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($employee['employee_id']); ?>">
                        <?php echo htmlspecialchars($employee['employee_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <br><br>
            <label for="booking">Select Booking:</label>
            <select name="booking_id" id="booking" required>
                <?php while ($booking = $bookings_result->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($booking['booking_id']); ?>">
                        <?php echo htmlspecialchars($booking['username']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <br><br>
            <input type="submit" value="Assign Booking">
        </form>
    </div>
</body>
</html>