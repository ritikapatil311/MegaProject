<!DOCTYPE html>
<html>
<head>
  <title>Requests</title>
  <style>
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
    .request-card {
      background-color: #fff;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 20px;
    }
    .request-card p {
      margin-bottom: 10px;
    }
    .request-card .status {
      font-weight: bold;
    }
    .request-card .accept {
      color: green;
    }
    .request-card .decline {
      color: red;
    }
    .request-card .actions {
      margin-top: 10px;
    }
    .request-card .actions button {
      padding: 5px 10px;
      margin-right: 10px;
      border-radius: 4px;
      cursor: pointer;
    }
    .request-card .actions .accept-btn {
      background-color: green;
      color: white;
      border: none;
    }
    .request-card .actions .decline-btn {
      background-color: red;
      color: white;
      border: none;
    }

  </style>
</head>
<body>
  <div class="container">
    <h1>Requests</h1>
    <?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        // Redirect to the login page if the user is not logged in
        header("Location: politicianLogin.php");
        exit();
    }

    // Retrieve the requests from the database
    $mysqli = new mysqli('localhost', 'root', '', 'rc');
    if ($mysqli->connect_error) {
      die('Connection failed: ' . $mysqli->connect_error);
    }

    $politicianId = $_SESSION['user_id'];

    $requestsStmt = $mysqli->prepare('SELECT * FROM requests WHERE politician_id = ?');
    $requestsStmt->bind_param('i', $politicianId);
    $requestsStmt->execute();
    $requestsResult = $requestsStmt->get_result();

    // Display each request as a card
    while ($request = $requestsResult->fetch_assoc()) {
      echo '<div class="request-card">';
      echo '<p><strong>Request ID:</strong> ' . $request['id'] . '</p>';
      echo '<p><strong>Message:</strong> ' . $request['message'] . '</p>';
      echo '<p class="status">';
      
      // Check the status and display corresponding text and color
      if ($request['status'] === 'Accepted') {
        echo '<span class="accept">Accepted</span>';
      } elseif ($request['status'] === 'Declined') {
        echo '<span class="decline">Declined</span>';
      } else {
        echo 'Pending';
      }
      
      echo '</p>';
      
      // Display actions (Accept and Decline buttons) for pending requests
      if ($request['status'] === 'Pending') {
        echo '<div class="actions">';
        echo '<button class="accept-btn" onclick="handleAction(' . $request['id'] . ', \'accept\')">Accept</button>';
        echo '<button class="decline-btn" onclick="handleAction(' . $request['id'] . ', \'decline\')">Decline</button>';
        echo '</div>';
      }
      
      echo '</div>';
    }

    $requestsStmt->close();
    $mysqli->close();
    ?>
  </div>

  <script>
    function handleAction(requestId, action) {
      // Send the request ID and action to the server
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'processRequest.php');
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          // Reload the page after successful action
          location.reload();
        }
      };
      xhr.send('request_id=' + requestId + '&action=' + action);
    }
  </script>
</body>
</html>
