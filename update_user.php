<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are filled
    if (isset($_POST['uid'], $_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['password'], $_POST['cpassword'])) {
        $userId = $_POST['uid'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        // Database connection
        $mysqli = new mysqli('localhost', 'root', '', 'rc');

        // Check if the connection was successful
        if ($mysqli->connect_errno) {
            echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
            exit();
        }

        // Update user
        $stmt = $mysqli->prepare('UPDATE users SET name = ?, email = ?, mobile = ?, password = ?, cpassword = ? WHERE uid = ?');
        $stmt->bind_param('sssssi', $name, $email, $mobile, $password, $cpassword, $userId);
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            echo 'User updated successfully';
        } else {
            echo 'Failed to update user';
        }

        // Close statement and database connection
        $stmt->close();
        $mysqli->close();
    } else {
        echo 'Please fill all required fields';
    }
} else {
    echo 'Invalid request';
}
?>
