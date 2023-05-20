<!DOCTYPE html>
<html>
<head>
  <title>User Management</title>
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
    h1 {
      text-align: center;
    }
    .user-list {
      list-style: none;
      padding: 0;
    }
    .user-list li {
      background-color: #fff;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 10px;
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .user-list li .user-info {
      flex: 1;
    }
    .user-list li .user-actions {
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }
    .user-actions a {
      margin-left: 10px;
    }
    .user-actions a.button-delete {
      color: red;
    }
    .user-actions a.button-delete:hover {
      color: darkred;
    }
    .user-form label {
      display: block;
      margin-bottom: 5px;
    }
    .user-form input[type="text"],
    .user-form input[type="password"] {
      width: 100%;
      padding: 5px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .user-form button {
      padding: 5px 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    /* Admin Matrix Template CSS */
    .admin-matrix {
      background-color: #f9f9f9;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }
    .admin-matrix .header {
      background-color: #4CAF50;
      color: #fff;
      padding: 10px;
      text-align: center;
      font-weight: bold;
      border-radius: 4px 4px 0 0;
    }
    .admin-matrix .content {
      margin-top: 20px;
    }
    .admin-matrix .content label {
      color: #333;
      font-weight: bold;
    }
    .admin-matrix .content input[type="text"],
    .admin-matrix .content input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 10px;
      box-sizing: border-box;
    }
    .admin-matrix .content button {
      padding: 10px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Admin Panel</h1>
    <div class="admin-matrix">
      <div class="header">User List</div>
      <ul class="user-list">
        <!-- PHP logic to retrieve and display users -->
        <?php
        // Database connection
        $mysqli = new mysqli('localhost', 'root', '', 'rc');

        // Check if the connection was successful
        if ($mysqli->connect_errno) {
            echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
            exit();
        }

        // Fetch users
        $result = $mysqli->query('SELECT uid, name FROM users');
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<li>';
                echo '<div class="user-info">';
                echo '<span>ID: ' . htmlspecialchars($row['uid']) . '</span>';
                echo '<span>Name: ' . htmlspecialchars($row['name']) . '</span>';
                echo '</div>';
                echo '<div class="user-actions">';
                echo '<a href="edit_user.php?id=' . htmlspecialchars($row['uid']) . '">Edit</a>';
                echo '<a href="delete_user.php?id=' . htmlspecialchars($row['uid']) . '" class="button-delete">Delete</a>';
                echo '</div>';
                echo '</li>';
            }
        } else {
            echo '<li>No users found</li>';
        }

        // Close database connection
        $mysqli->close();
        ?>
      </ul>
    </div>
    <h2>Create User</h2>
    <div class="admin-matrix">
      <form class="user-form" action="create_user.php" method="POST">
        <div class="content">
          <label for="name">Name:</label>
          <input type="text" name="name" id="name" required>
          <label for="email">Email:</label>
          <input type="text" name="email" id="email" required>
          <label for="mobile">Mobile:</label>
          <input type="text" name="mobile" id="mobile" required>
          <label for="password">Password:</label>
          <input type="password" name="password" id="password" required>
          <label for="cpassword">Confirm Password:</label>
          <input type="password" name="cpassword" id="cpassword" required>
          <button type="submit">Create</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
