<?php
include('config.php');

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Update booking status to 'cancelled'
    $stmt = $conn->prepare("UPDATE booking_info SET status = 'cancelled' WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        // Set success message
        $message = "This booking has been cancelled.";
    } else {
        // Set error message
        $message = "Error cancelling this booking.";
    }

    $stmt->close();
} else {
    // Set error message if no booking_id is provided
    $message = "No booking ID provided.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .message {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .back-link {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($message): ?>
            <div class="<?php echo strpos($message, 'Error') === false ? 'message' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <a class="back-link" href="booking.php">Back to Bookings</a>
    </div>
</body>
</html>
