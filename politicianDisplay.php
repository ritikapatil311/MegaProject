<?php
session_start();
$politicianId = ""; // Initialize politician ID

if (isset($_SESSION['user_id'])) {
    $politicianId = $_SESSION['user_id']; // Retrieve politician ID from session
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in as a politician
    if ($politicianId) {
        $comment = $_POST['comment'];
        $postId = $_POST['postId'];

        // Connect to the database
        $mysqli = new mysqli('localhost', 'root', '', 'rc');

        // Check connection
        if ($mysqli->connect_error) {
            die('Connection failed: ' . $mysqli->connect_error);
        }

        // Prepare the SQL statement to insert the comment
        $stmt = $mysqli->prepare('INSERT INTO politician_comments (post_id, politician_id, comment) VALUES (?, ?, ?)');

        // Bind the parameters
        $stmt->bind_param('iis', $postId, $politicianId, $comment);

        // Execute the query
        if ($stmt->execute()) {
            // Comment inserted successfully
            // Redirect to the same page to avoid duplicate form submissions
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            // Failed to insert comment
            echo "Error: " . $stmt->error;
        }

        // Close the statement and database connection
        $stmt->close();
        $mysqli->close();
    } else {
        // User is not logged in as a politician
        echo "You must be logged in as a politician to comment.";
    }
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

    .post .comments {
      margin-top: 10px;
    }

    .post .comments h4 {
      margin-bottom: 5px;
    }

    .post .comments p {
      margin-bottom: 5px;
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
