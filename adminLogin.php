<?php
session_start();

// Check if the admin is already logged in
if (isset($_SESSION['admin_id'])) {
    // Redirect to the admin dashboard
    header("Location: adminDashboard.php");
    exit();
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $mysqli = new mysqli('localhost', 'root', '', 'rc');

    // Check if the connection was successful
    if ($mysqli->connect_errno) {
        echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
        exit();
    }

    // Sanitize the entered email and password to prevent SQL injection
    $admin_email = $mysqli->real_escape_string($_POST['email']);
    $admin_password = $mysqli->real_escape_string($_POST['password']);

    // Query the admins table to check the credentials
    $query = "SELECT id FROM admins WHERE email = '$admin_email' AND password = MD5('$admin_password')";
    $result = $mysqli->query($query);

    // Check if the login is successful
    if ($result->num_rows === 1) {
        // Get the admin ID from the query result
        $row = $result->fetch_assoc();
        $admin_id = $row['id'];

        // Set the admin session
        $_SESSION['admin_id'] = $admin_id;

        // Redirect to the admin dashboard
        header("Location: adminDashboard.php");
        exit();
    } else {
        // Invalid login credentials, show an error message
        $error_message = "Invalid login credentials";
    }

    // Close database connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h3 class="mt-5 mb-4 text-center">Admin Login</h3>
                <?php if (isset($error_message)) : ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
