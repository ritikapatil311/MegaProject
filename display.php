<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
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
      background-color: #141d26;
      color: #fff;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #1da1f2;
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
      background-color: #192734;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .post img {
      width: 100%;
      height: auto;
      border-radius: 8px;
    }

    .post p {
      margin-top: 10px;
      font-size: 14px;
    }

    .comment {
      margin-top: 10px;
      font-size: 14px;
      background-color: #253341;
      padding: 8px;
      border-radius: 8px;
    }

    .comment p {
      margin: 0;
    }

    .logout-btn {
      text-align: center;
      margin-top: 20px;
    }

    .btn {
      display: inline-block;
      padding: 8px 16px;
      border-radius: 9999px;
      text-decoration: none;
      font-size: 14px;
      font-weight: bold;
      color: #fff;
      background-color: #1da1f2;
      border: none;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #0c87b8;
    }
  </style>
</head>
<body>

<h1>Image Feed</h1>
<div class="feed">
    <?php
    $mysqli = new mysqli('localhost', 'root', '', 'rc');

    $result = $mysqli->query('SELECT posts.*, users.name AS username FROM posts JOIN users ON posts.user_id = users.uid ORDER BY posts.id DESC');

    while ($row = $result->fetch_assoc()) {
        echo '<div class="post">';
        echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Post Image">';
        echo '<p><strong>Uploaded by:</strong> ' . htmlspecialchars($row['username']) . '</p>';
        echo '<p><strong>Pincode:</strong> ' . htmlspecialchars($row['pincode']) . '</p>';
        echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
        echo '<p>' . htmlspecialchars($row['caption']) . '</p>';

        $postID = $row['id'];
        $commentsResult = $mysqli->query("SELECT politician_comments.*, politicians.name AS politician_name FROM politician_comments JOIN politicians ON politician_comments.politician_id = politicians.id WHERE politician_comments.post_id = $postID");
        
        if ($commentsResult && $commentsResult->num_rows > 0) {
            while ($commentRow = $commentsResult->fetch_assoc()) {
                echo '<div class="comment">';
                echo '<p><strong>Politician:</strong> ' . htmlspecialchars($commentRow['politician_name']) . '</p>';
                echo '<p><strong>Comment:</strong> ' . htmlspecialchars($commentRow['comment']) . '</p>';
                echo '</div>';
            }
            $commentsResult->free();
        } else {
            echo '<p>No comments available</p>';
        }

        echo '</div>';
    }

    $result->free();
    $mysqli->close();
    ?>
</div>
<div class="logout-btn">
    <a href="logout.php" class="btn">Logout</a>
</div>
</body>
</html>
