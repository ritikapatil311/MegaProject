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
      flex-wrap: wrap;
      justify-content: center;
    }

    .post {
      width: 300px;
      margin: 10px;
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
  </style>
</head>
<body>
  <h1>Image Feed</h1>
  <div class="feed">
    <?php
    $mysqli = new mysqli('localhost', 'root', '', 'rc');

    $result = $mysqli->query('SELECT * FROM posts ORDER BY id DESC');

    while ($row = $result->fetch_assoc()) {
        echo '<div class="post">';
        echo '<img src="' . $row['image'] . '" alt="Post Image">';
        echo '<p>' . $row['caption'] . '</p>';
        echo '</div>';
    }

    $result->free();
    $mysqli->close();
    ?>
  </div>
</body>
</html>
