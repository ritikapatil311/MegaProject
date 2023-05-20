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
    .user-name {
      text-align: center;
      font-size: 20px;
      margin-bottom: 20px;
    }
    .post img {
      max-width: 100%;
      height: auto;
    }
    body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
        }
        .username {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .image-list {
            list-style: none;
            padding: 0;
        }
        .image-list li {
            margin-bottom: 10px;
        }
        .image-list li a {
            display: inline-block;
            margin-right: 10px;
        }
        .image-list li img {
            max-width: 150px;
            height: auto;
        }
        .caption {
            margin-top: 5px;
            font-size: 14px;
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

    $stmt = $mysqli->prepare('SELECT image, caption FROM posts WHERE user_id = ? ORDER BY id DESC');
    $stmt->bind_param('i', $userID);
    $stmt->execute();
    $stmt->bind_result($image, $caption);

    while ($stmt->fetch()) {
        echo '<div class="post">';
        echo '<img src="' . htmlspecialchars($image) . '" alt="Post Image">';
        echo '<p>' . htmlspecialchars($caption) . '</p>';
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
