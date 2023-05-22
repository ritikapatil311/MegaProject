<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connect to the database
    $mysqli = new mysqli('localhost', 'root', '', 'rc');

    // Check connection
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    // Prepare the SQL statement
    $stmt = $mysqli->prepare('SELECT id FROM politicians WHERE email = ? AND password = ?');

    // Bind the parameters
    $stmt->bind_param('ss', $email, $password);

    // Execute the query
    $stmt->execute();

    // Bind the result
    $stmt->bind_result($politicianId);

    // Fetch the result
    if ($stmt->fetch()) {
        // Login successful
        $_SESSION['user_id'] = $politicianId;
        header("Location: politicianDisplay.php");
        exit();
    } else {
        // Login failed
        echo "Invalid login credentials";
    }

    // Close the statement and database connection
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
