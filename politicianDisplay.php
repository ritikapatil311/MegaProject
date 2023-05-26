<?php
session_start();
$politicianId = ""; 

if (isset($_SESSION['user_id'])) {
    $politicianId = $_SESSION['user_id']; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if ($politicianId) {
        $comment = $_POST['comment'];
        $postId = $_POST['postId'];

        
        $mysqli = new mysqli('localhost', 'root', '', 'rc');

        
        if ($mysqli->connect_error) {
            die('Connection failed: ' . $mysqli->connect_error);
        }

        
        $stmt = $mysqli->prepare('INSERT INTO politician_comments (post_id, politician_id, comment) VALUES (?, ?, ?)');

        
        $stmt->bind_param('iis', $postId, $politicianId, $comment);

        
        if ($stmt->execute()) {
            
            
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            
            echo "Error: " . $stmt->error;
        }

        
        $stmt->close();
        $mysqli->close();
    } else {
        
        echo "You must be logged in as a politician to comment.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Image Feed</title>
  <style>
    <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #fafafa;
    }

    h1 {
      text-align: center;
      margin-bottom: 40px;
      color: #262626;
    }

    .feed {
      max-width: 600px;
      margin: 0 auto;
    }

    .post {
      margin-bottom: 40px;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 3px;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .post img {
      width: 100%;
      display: block;
    }

    .post .details {
      padding: 16px;
    }

    .post .details .username {
      font-size: 14px;
      font-weight: bold;
      color: #262626;
      margin-bottom: 8px;
    }

    .post .details .location {
      font-size: 12px;
      color: #888;
      margin-bottom: 8px;
    }

    .post .details .caption {
      font-size: 14px;
      margin-bottom: 8px;
    }

    .post .comments {
      padding: 16px;
      background-color: #f9f9f9;
    }

    .post .comments .comment {
      margin-bottom: 8px;
    }

    .post .comments .comment p {
      font-size: 14px;
      margin: 0;
    }

    .post .comment-form {
      padding: 16px;
      background-color: #f9f9f9;
    }

    .post .comment-form input[type="text"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 3px;
      outline: none;
    }

    .post .comment-form input[type="submit"] {
      display: block;
      width: 100%;
      margin-top: 8px;
      padding: 8px;
      background-color: #3897f0;
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      outline: none;
    }

    .post .comment-form input[type="submit"]:hover {
      background-color: #2676d9;
    }

    .logout-btn {
      text-align: center;
      margin-top: 20px;
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
        echo '<p>Uploaded by: ' . htmlspecialchars($row['username']) . '</p>';
        echo '<p>Pincode: ' . htmlspecialchars($row['pincode']) . '</p>';
        echo '<p>Location: ' . htmlspecialchars($row['location']) . '</p>';
        echo '<p>' . htmlspecialchars($row['caption']) . '</p>';

        // Display existing comments
        echo '<div class="comments">';
        echo '<h4>Comments:</h4>';
        $postId = $row['id'];
        $commentResult = $mysqli->query("SELECT comment FROM politician_comments WHERE post_id = $postId AND politician_id = $politicianId");
        if ($commentResult) {
            while ($commentRow = $commentResult->fetch_assoc()) {
                echo '<p>' . htmlspecialchars($commentRow['comment']) . '</p>';
            }
            $commentResult->free();
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
</body>
</html>
