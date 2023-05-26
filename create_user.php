<?php
$mysqli = new mysqli('localhost', 'root', '', 'rc');

if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $stmt = $mysqli->prepare('INSERT INTO users (name, email, mobile, password, cpassword) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssss', $name, $email, $mobile, $password, $cpassword);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // User created successfully
        header('Location: admin.php');
        exit();
    } else {
        echo 'Failed to create user';
    }

    $stmt->close();
}

$mysqli->close();
?>
