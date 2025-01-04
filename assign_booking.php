<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $booking_id = $_POST['booking_id'];

    // Check if the employee and booking are valid
    $employee_result = $conn->query("SELECT employee_id FROM employees WHERE employee_id = $employee_id");
    $booking_result = $conn->query("SELECT booking_id FROM booking_info WHERE booking_id = $booking_id");

    if ($employee_result->num_rows > 0 && $booking_result->num_rows > 0) {
        // Assign the booking to the employee
        $sql = "INSERT INTO employee_bookings (employee_id, booking_id, booking_date) VALUES ($employee_id, $booking_id, NOW())";
        if ($conn->query($sql) === TRUE) {
            echo "Booking assigned to employee successfully!";

            $sql1 = "UPDATE booking_info SET status= 'confirmed' WHERE booking_id= '$booking_id'";

            // Execute the query
            if ($conn->query($sql1) === TRUE) {
                echo '<script>alert("Record successful");';
    
                echo 'window.location.href = "booking.php"   ;</script>';
                exit();
                        } else {
                echo "Error updating record: " . $conn->error;
                   } } else {
            echo "Error: " . $sql1 . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid employee or booking.";
    }

    $conn->close();
}
?>