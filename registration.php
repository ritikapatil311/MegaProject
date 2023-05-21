<?php
  require_once "db.php";

  if(isset($_SESSION['user_id'])!="") {
    header("Location: dashboard.php");
  }

  if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $role = mysqli_real_escape_string($conn, $_POST['role']); // Add role field in the form

    if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
      $name_error = "Name must contain only alphabets and space";
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
      $email_error = "Please Enter Valid Email ID";
    }
    if(strlen($password) < 6) {
      $password_error = "Password must be a minimum of 6 characters";
    }       
    if(strlen($mobile) < 10) {
      $mobile_error = "Mobile number must be a minimum of 10 characters";
    }
    if($password != $cpassword) {
      $cpassword_error = "Password and Confirm Password don't match";
    }

    if (!$name_error && !$email_error && !$password_error && !$mobile_error && !$cpassword_error) {
      if ($role == 'admin') {
        if(mysqli_query($conn, "INSERT INTO admins(name, email, mobile, password) VALUES('" . $name . "', '" . $email . "', '" . $mobile . "', '" . md5($password) . "')")) {
          header("location: login.php"); // Redirect to login page
          exit();
        } else {
          echo "Error: " . $sql . "" . mysqli_error($conn);
        }
      } else {
        if(mysqli_query($conn, "INSERT INTO users(name, email, mobile, password) VALUES('" . $name . "', '" . $email . "', '" . $mobile . "', '" . md5($password) . "')")) {
          header("location: login.php"); // Redirect to login page
          exit();
        } else {
          echo "Error: " . $sql . "" . mysqli_error($conn);
        }
      }
    }
    mysqli_close($conn);
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
  <title>Registration Form</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-offset-2">
        <div class="page-header">
          <h2>Please Register to Login</h2>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="" maxlength="50" required="">
            <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="" maxlength="30" required="">
            <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
          </div>

          <div class="form-group">
            <label>Mobile</label>
            <input type="text" name="mobile" class="form-control" value="" maxlength="12" required="">
            <span class="text-danger"><?php if (isset($mobile_error)) echo $mobile_error; ?></span>
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="" maxlength="8" required="">
            <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
          </div>

          <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="cpassword" class="form-control" value="" maxlength="8" required="">
            <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
          </div>

          <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control">
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <input type="submit" class="btn btn-primary" name="signup" value="Submit">
          Already have an account? <a href="login.php" class="btn btn-default">Login</a>
        </form>
      </div>
    </div>
  </div>

  <div class="d-flex flex-column justify-content-center w-100 h-100"></div>
</body>
</html>
