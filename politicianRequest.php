<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: politicianLogin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission
    // ...

    // Insert the request into the database
    $mysqli = new mysqli('localhost', 'root', '', 'rc');
    
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    $politicianId = $_SESSION['user_id'];
    $status = 'Pending';
    $message = $_POST['message'];

    // Retrieve politician name from the politicians table
    $politicianName = '';
    $stmt = $mysqli->prepare('SELECT name FROM politicians WHERE id = ?');
    $stmt->bind_param('i', $politicianId);
    $stmt->execute();
    $stmt->bind_result($politicianName);
    $stmt->fetch();
    $stmt->close();

    // Insert the request into the requests table
    $requestStmt = $mysqli->prepare('INSERT INTO requests (politician_id, politician_name, status, message) VALUES (?, ?, ?, ?)');
    $requestStmt->bind_param('isss', $politicianId, $politicianName, $status, $message);
    $requestStmt->execute();
    $requestStmt->close();

    $mysqli->close();

    // Redirect to the success page
    header("Location: requests.php?response=pending");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Politician Request</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f1f1f1;
    }
    .container {
      max-width: 600px;
      margin: 40px auto;
    }
    h1 {
      text-align: center;
    }
    .request-form {
      background-color: #fff;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }
    .request-form label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }
    .request-form input[type="file"] {
      margin-bottom: 10px;
    }
    .request-form textarea {
      width: 100%;
      height: 100px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      resize: vertical;
    }
    .request-form button {
      padding: 5px 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .status {
      margin-top: 20px;
      text-align: center;
    }
    .status .tick {
      color: green;
      font-size: 24px;
    }
    .status .pending {
      color: orange;
      font-size: 24px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Politician Request</h1>
    <div class="request-form">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <label for="photo">Upload Photo:</label>
        <input type="file" name="photo" id="photo" required>
        <label for="message">Message:</label>
        <textarea name="message" id="message" required></textarea>
        <button type="submit">Send Request</button>
      </form>
    </div>
    <div class="status">
      <?php
      // Check if the response is set
      if (isset($_GET['response'])) {
        $response = $_GET['response'];
        if ($response === 'accepted') {
          echo '<span class="tick">&#10004;</span> Request Accepted';
        } elseif ($response === 'pending') {
          echo '<span class="pending">&#8987;</span> Request Pending';
        }
      }
      ?>
    </div>
  </div>
</body>
</html>
