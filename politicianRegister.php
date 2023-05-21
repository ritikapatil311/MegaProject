<?php
session_start();

if(isset($_SESSION['user_id'])) {
    header("Location: politicianDisplay.php");
    exit();
}

require_once "db.php";

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please enter a valid email address";
    }
    if(strlen($password) < 6) {
        $password_error = "Password must be a minimum of 6 characters";
    }

    // Check if the email already exists in the politicians table
    $result = mysqli_query($conn, "SELECT * FROM politicians WHERE email = '" . $email . "'");
    if(mysqli_num_rows($result) > 0){
        $error_message = "Email already exists. Please choose a different email.";
    } else {
        // Insert the new politician into the politicians table
        $insertPolitician = "INSERT INTO politicians (name, email, password) VALUES ('$name', '$email', '$password')";
        mysqli_query($conn, $insertPolitician);

        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;

        header("Location: politicianDisplay.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Politician Registration</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-10">
            <div class="page-header">
                <h2>Politician Registration</h2>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group ">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="" maxlength="255" required="">
                </div>
                <div class="form-group ">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="" maxlength="255" required="">
                    <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                    <span class="text-danger"><?php if (isset($error_message)) echo $error_message; ?></span>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="" maxlength="255" required="">
                    <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                </div>
                <input type="submit" class="btn btn-primary" name="register" value="Register">
            </form>
            <p>Already have an account? <a href="politicianLogin.php">Login here</a></p>
        </div>
    </div>
</div>
</body>
</html>
