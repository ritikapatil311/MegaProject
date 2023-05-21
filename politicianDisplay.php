<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $postId = $_POST['postId'];
    $politicianId = $_SESSION['user_id'];

    // Insert the comment into the politician_comments table
    $mysqli = new mysqli('localhost', 'root', '', 'rc');
    $stmt = $mysqli->prepare('INSERT INTO politician_comments (politician_id, post_id, comment) VALUES (?, ?, ?)');
    $stmt->bind_param('iis', $politicianId, $postId, $comment);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Image Feed</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
    }

    .feed {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .post {
      width: 600px;
      margin-bottom: 20px;
      padding: 10px;
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .post img {
      width: 100%;
      height: auto;
    }

    .post p {
      margin-top: 10px;
      font-size: 14px;
    }

    .post .comment-form {
      margin-top: 10px;
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
  <div class="feed">
    <?php
    $mysqli = new mysqli('localhost', 'root', '', 'rc');

    $result = $mysqli->query('SELECT posts.*, users.name AS username FROM posts JOIN users ON posts.user_id = users.uid ORDER BY posts.id DESC');

    while ($row = $result->fetch_assoc()) {
        echo '<div class="post">';
        echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Post Image">';
        echo '<p>Uploaded by: ' . htmlspecialchars($row['username']) . '</p>';
        echo '<p>Pincode: ' . htmlspecialchars($row['pincode']) . '</p>';
        echo '<p>Location: ' . htmlspecialchars($row['location']) . '</p>';
        echo '<p>' . htmlspecialchars($row['caption']) . '</p>';

        // Display existing comments
        echo '<div class="comments">';
        echo '<h4>Comments:</h4>';
        $politicianId = $_SESSION['user_id'];
        $politicianResult = $mysqli->query("SELECT comment FROM politician_comments WHERE politician_id = $politicianId AND post_id = " . $row['id']);
        if ($politicianResult) {
            while ($commentRow = $politicianResult->fetch_assoc()) {
                echo '<p>' . htmlspecialchars($commentRow['comment']) . '</p>';
            }
            $politicianResult->free();
        }
        echo '</div>';

        // Comment form
        echo '<form class="comment-form" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">';
        echo '<input type="hidden" name="postId" value="' . htmlspecialchars($row['id']) . '">';
        echo '<input type="text" name="comment" placeholder="Write a comment..." required>';
        echo '<input type="submit" value="Comment">';
        echo '</form>';

        echo '</div>';
    }

    $result->free();
    $mysqli->close();
    ?>
  </div>
  <div class="logout-btn">
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</body>
</html>
