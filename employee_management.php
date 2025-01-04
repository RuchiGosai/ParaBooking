<?php
include 'config.php';
session_start();

$un = $_SESSION['username'];
if (!$un) {
    header("Location: login1.php");
    exit();
}

$successMessage = "";

// Handle form submission to add a pilot
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_name'], $_POST['email'], $_POST['address'])) {
    $employeeName = $_POST['employee_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Server-side validation for name and address
    if (!preg_match('/^[A-Za-z\s]{4,}$/', $employeeName)) {
        echo "Name must be more than 3 characters long and contain only letters and spaces.";
        exit();
    }

    if (!preg_match('/^[A-Za-z\s]{4,}$/', $address)) {
        echo "Address must start with a letter and be at least 4 characters long.";
        exit();
    }

    // Insert pilot into the database
    $sql = "INSERT INTO employees (employee_name, email, address) VALUES ('$employeeName', '$email', '$address')";
    if ($conn->query($sql) === TRUE) {
        $successMessage = "Pilot added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all employees
$result = $conn->query("SELECT * FROM employees");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilot Management</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }        
        .add-pilot-form {
    display: grid;
    gap: 10px;
    grid-template-columns: max-content auto; /* Label and input in two columns */
    max-width: 400px; /* Adjust max-width as needed */
    margin: auto;
    background-color: rgba(179, 229, 252); 
    padding: 20px;
    border: 1px solid #ccc; /* Add border */
    border-radius: 10px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

.add-pilot-form h2 {
    margin-top: 0;
    margin-bottom: 15px;
}

.add-pilot-form label {
    font-weight: bold;
}

.add-pilot-form input[type="text"],
.add-pilot-form input[type="email"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    margin-bottom: 10px; /* Add margin between input boxes */
    width: calc(60% - 16px); /* Adjust input width to accommodate border */
}

.add-pilot-form input[type="text"]:focus,
.add-pilot-form input[type="email"]:focus {
    border-color: #009879; /* Change border color on focus */
    outline: none; /* Remove default focus outline */
}

.add-pilot-button {
    background-color: #73AD21;
    color: white; /* Optional: makes text more readable */
    border: none;
    padding: 10px 20px; 
    cursor: pointer; 
}

.add-pilot-button:hover {
    background-color: #5c8b17;
}


.add-pilot-form button[type="submit"] {
    background-color: #73AD21;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.add-pilot-form button[type="submit"]:hover {
    background-color: #5c8b17; /* Darker shade on hover */
}
    </style>
    <script>
    function validateForm() {
        const nameInput = document.getElementById('employee_name');
        const addressInput = document.getElementById('address');
        const nameRegex = /^[A-Za-z\s]{4,}$/; // Letters and spaces, minimum 4 characters
        const addressRegex = /^[A-Za-z\s]{4,}$/; // Starts with a letter, minimum 4 characters

        if (!nameRegex.test(nameInput.value)) {
            alert('Enter valid name.');
            nameInput.focus();
            return false;
        }

        if (!addressRegex.test(addressInput.value)) {
            alert('Enter valid address.');
            addressInput.focus();
            return false;
        }

        return true;
    }

    function showAddPilotForm() {
        document.getElementById('add-pilot-form').style.display = 'block';
    }
    </script>
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
        <h1>Pilot Records</h1>
        <table>
            <tr>
                <th>Employee_id</th>
                <th>Employee_name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['employee_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['address']) . "</td>";

                echo "<td>";
                echo "<a href='edit_user.php?employee_id=" . htmlspecialchars($row['employee_id']) . "'>Edit</a> | ";
                echo "<a href='delete_employee.php?employee_id=" . htmlspecialchars($row['employee_id']) . "'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            $conn->close();
            ?>
        </table>

        <button class="add-pilot-button" onclick="showAddPilotForm()">Add Pilot</button>

        <div id="add-pilot-form" class="add-pilot-form" style="display:none;">
            <h2>Add Pilot</h2>
            <form action="employee_management.php" method="POST" onsubmit="return validateForm()">
                <label for="employee_name">Name:</label>
                <input type="text" id="employee_name" maxlength="20" name="employee_name" required><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required><br>
                <button type="submit" style="cursor: pointer;">Add Pilot</button>
            </form>
        </div>

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
