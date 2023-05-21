<!DOCTYPE html>
<html>
<head>
  <title>Edit User</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      padding-top: 40px;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php
    // Check if user ID is provided
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        // Database connection
        $mysqli = new mysqli('localhost', 'root', '', 'rc');

        // Check if the connection was successful
        if ($mysqli->connect_errno) {
            echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
            exit();
        }

        // Prepare statement
        $stmt = $mysqli->prepare('SELECT uid, name, email, mobile, password, cpassword FROM users WHERE uid = ?');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Display user information
            echo '<h2 class="mb-4">Edit User</h2>';
            echo '<form class="user-form" action="update_user.php" method="POST">';
            echo '<input type="hidden" name="uid" value="' . htmlspecialchars($user['uid']) . '">';
            echo '<div class="form-group">';
            echo '<label for="name">Name:</label>';
            echo '<input type="text" class="form-control" name="name" id="name" value="' . htmlspecialchars($user['name']) . '" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="email">Email:</label>';
            echo '<input type="text" class="form-control" name="email" id="email" value="' . htmlspecialchars($user['email']) . '" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="mobile">Mobile:</label>';
            echo '<input type="text" class="form-control" name="mobile" id="mobile" value="' . htmlspecialchars($user['mobile']) . '" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="password">Password:</label>';
            echo '<input type="password" class="form-control" name="password" id="password" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="cpassword">Confirm Password:</label>';
            echo '<input type="password" class="form-control" name="cpassword" id="cpassword" required>';
            echo '</div>';
            echo '<button type="submit" class="btn btn-primary">Update</button>';
            echo '</form>';
        } else {
            echo 'User not found';
        }

        // Close statement and database connection
        $stmt->close();
        $mysqli->close();
    } else {
        echo 'Invalid user ID';
    }
    ?>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    // Show success message and redirect after form submission
    document.addEventListener('DOMContentLoaded', function() {
      var form = document.querySelector('.user-form');
      form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission
        var popup = document.createElement('div');
        popup.classList.add('alert', 'alert-success', 'mt-4');
        popup.textContent = 'The user information has been updated successfully.';
        document.querySelector('.container').appendChild(popup);
        setTimeout(function() {
          popup.remove(); // Remove success message after 3 seconds
          window.location.href = 'admin.php'; // Redirect to admin.php
        }, 3000);
      });
    });
  </script>
</body>
</html>
