<?php
include('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from the POST request
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $date = $_POST['date'];
    $time = $_POST['time'];
    $phone = $_POST['phoneNumber'];
    $fullname = $_POST['name'];


    // Create the SQL query
    $sql = "INSERT INTO booking_info (username, email,  booking_date, booking_time, status ) 
            VALUES ('$name', '$email', '$date', '$time', 'pending')";

$sql1 = "INSERT INTO users (username, password, email, full_name, phone_number) VALUES (?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("sssss", $name, $password, $email, $fullname, $phone);

if ($stmt1->execute()) {
    echo "New record created successfully";
    $_SESSION["email"] = "$email";
$_SESSION["password"] = "$password";
    header('Location: thank_you.php');
} else {
    echo "Error: " . $sq1 . "<br>" . $conn->error;
}

$stmt1->close();

    if ($conn->query($sql) == TRUE) {
        // Redirect or show a success message
        header("Location: thank_you.php");
        exit();

    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    // If the script is accessed without POST data, redirect to the form page
    header("Location: testing.php");
    exit();
}




