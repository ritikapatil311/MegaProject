<?php
session_start();

require_once "db.php";

if(isset($_SESSION['user_id'])!="") {
    header("Location: index.php");
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please Enter Valid Email ID";
    }
    if(strlen($password) < 6) {
        $password_error = "Password must be a minimum of 6 characters";
    }  

    // Check if the user is in the users table
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '" . $email. "' and password = '" . md5($password). "'");
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $_SESSION['user_id'] = $row['uid'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_mobile'] = $row['mobile'];

        header("Location: wall.php"); // Redirect to wall.php for regular user
        exit();
    }

    $error_message = "Incorrect Email or Password!!!";
    echo '<script>alert("Incorrect password or username")</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            height: 100vh;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }  
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="page-header">
                    <h2>WELCOME TO REALITY CHECK</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group ">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="" maxlength="30" required="">
                        <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" value="" maxlength="8" required="">
                        <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                    </div>  
                    <input type="submit" class="btn btn-primary" name="login" value="Submit">
                    <br>
                    Don't have an account? <a href="registration.php" class="mt-3">Click Here</a>
                </form>
            </div>
        </div>     
    </div>
    <div class="d-flex flex-column justify-content-center w-100 h-100"></div>
</body>
</html>
