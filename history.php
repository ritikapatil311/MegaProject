<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the logged-in user's ID and name from the session
$userID = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Image Feed</title>
  <style>
    /* CSS styles here */
    body {
      font-family: Arial, sans-serif;
      background-color: #f1f1f1;
    }
    .container {
      max-width: 600px;
      margin: 40px auto;
    }
    .user-name {
      text-align: center;
      font-size: 20px;
      margin-bottom: 20px;
    }
    .post {
      background-color: #fff;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 10px;
      margin-bottom: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }
    .post img {
      max-width: 100%;
      max-height: 300px; /* Adjust the max-height value as needed */
      width: auto;
      height: auto;
      border-radius: 4px;
      object-fit: contain;
    }
    .caption {
      margin-top: 10px;
      font-size: 14px;
    }
    .location {
      font-size: 12px;
      margin-top: 5px;
      color: #888;
    }
    .pincode {
      font-size: 12px;
      color: #888;
    }
    .logout-btn {
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  <h1>Image Feed</h1>
  <div class="user-name">
    Active User: <?php echo htmlspecialchars($userName); ?>
  </div>
  <div class="feed">
    <?php
    $mysqli = new mysqli('localhost', 'root', '', 'rc');

    $stmt = $mysqli->prepare('SELECT image, caption, location, pincode FROM posts WHERE user_id = ? ORDER BY id DESC');
    $stmt->bind_param('i', $userID);
    $stmt->execute();
    $stmt->bind_result($image, $caption, $location, $pincode);

    while ($stmt->fetch()) {
        echo '<div class="post">';
        echo '<img src="' . htmlspecialchars($image) . '" alt="Post Image">';
        echo '<p class="caption">' . htmlspecialchars($caption) . '</p>';
        echo '<p class="location">' . htmlspecialchars($location) . '</p>';
        echo '<p class="pincode">Pin Code: ' . htmlspecialchars($pincode) . '</p>';
        echo '</div>';
    }

    $stmt->close();
    $mysqli->close();
    ?>
  </div>
  <div class="logout-btn">
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</body>
</html>
