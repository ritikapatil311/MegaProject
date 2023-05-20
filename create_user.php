<?php
// Database connection
$mysqli = new mysqli('localhost', 'root', '', 'rc');

// Check if the connection was successful
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate the input
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Perform any additional validation or sanitization here

    // Insert the new user into the database
    $stmt = $mysqli->prepare('INSERT INTO users (name, email, mobile, password, cpassword) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $name, $email, $mobile, $password, $cpassword);
    $stmt->execute();

    // Check if the user was created successfully
    if ($stmt->affected_rows > 0) {
        echo 'User created successfully';
    } else {
        echo 'Failed to create user';
    }

    $stmt->close();
}

// Close database connection
$mysqli->close();
?>
