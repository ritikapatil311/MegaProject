<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


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
      background-color: #141d26;
      color: #fff;
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
    .post-table {
      width: 100%;
      border-collapse: collapse;
    }
    .post-table th,
    .post-table td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #344656;
    }
    .post-table th {
      background-color: #192734;
    }
    .post-table img {
      max-width: 100px;
    }
    .logout-btn {
      text-align: center;
      margin-top: 20px;
    }
    .logout-btn a {
      background-color: #1da1f2;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      text-decoration: none;
    }
    .logout-btn a:hover {
      background-color: #0c87b8;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  <h1>Image Feed</h1>
  
  <table class="post-table">
    <thead>
      <tr>
        <th>Image</th>
        <th>Caption</th>
        <th>Location</th>
        <th>Pin Code</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $mysqli = new mysqli('localhost', 'root', '', 'rc');

      $stmt = $mysqli->prepare('SELECT image, caption, location, pincode FROM posts WHERE user_id = ? ORDER BY id DESC');
      $stmt->bind_param('i', $userID);
      $stmt->execute();
      $stmt->bind_result($image, $caption, $location, $pincode);

      while ($stmt->fetch()) {
          echo '<tr>';
          echo '<td><img src="' . htmlspecialchars($image) . '" alt="Post Image" style="max-width: 100px;"></td>';
          echo '<td>' . htmlspecialchars($caption) . '</td>';
          echo '<td>' . htmlspecialchars($location) . '</td>';
          echo '<td>' . htmlspecialchars($pincode) . '</td>';
          echo '</tr>';
      }

      $stmt->close();
      $mysqli->close();
      ?>
    </tbody>
  </table>
  <div class="logout-btn">
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</body>
</html>