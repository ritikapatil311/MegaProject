<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $mysqli = new mysqli('localhost', 'root', '', 'rc');

    
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    
    $stmt = $mysqli->prepare('SELECT id FROM politicians WHERE email = ? AND password = ?');

    
    $stmt->bind_param('ss', $email, $password);

    
    $stmt->execute();

    
    $stmt->bind_result($politicianId);

    
    if ($stmt->fetch()) {
        
        $_SESSION['user_id'] = $politicianId;
        header("Location: politicianDashboard.php");
        exit();
    } else {

        echo "Invalid login credentials";
    }

    
    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Politician Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
    }

    .login-form {
      max-width: 300px;
      margin: 0 auto;
    }

    .form-group {
      margin-bottom: 10px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
    }

    .form-group input {
      width: 100%;
      padding: 5px;
    }

    .form-group .btn {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      text-align: center;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <h1>Politician Login</h1>
  <div class="login-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
      </div>
      <div class="form-group">
        <input type="submit" value="Login" class="btn">
      </div>
    </form>
  </div>
</body>
</html>
