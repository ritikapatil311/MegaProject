<?php
session_start();


if (isset($_SESSION['admin_id'])) {

    header("Location: adminDashboard.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $mysqli = new mysqli('localhost', 'root', '', 'rc');


    if ($mysqli->connect_errno) {
        echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
        exit();
    }

    
    $admin_email = $mysqli->real_escape_string($_POST['email']);
    $admin_password = $mysqli->real_escape_string($_POST['password']);

    
    $query = "SELECT id FROM admins WHERE email = '$admin_email' AND password = MD5('$admin_password')";
    $result = $mysqli->query($query);

    
    if ($result->num_rows === 1) {
        
        $row = $result->fetch_assoc();
        $admin_id = $row['id'];

        
        $_SESSION['admin_id'] = $admin_id;

       
        header("Location: adminDashboard.php");
        exit();
    } else {
        
        $error_message = "Invalid login credentials";
    }

    
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
