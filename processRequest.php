<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: politicianLogin.php");
    exit();
}

$mysqli = new mysqli('localhost', 'root', '', 'rc');
if ($mysqli->connect_error) {
  die('Connection failed: ' . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $requestId = $_POST['request_id'];
  $action = $_POST['action'];

  if ($action === 'accept') {
    // Retrieve the request details from the requests table
    $requestStmt = $mysqli->prepare('SELECT * FROM requests WHERE id = ?');
    $requestStmt->bind_param('i', $requestId);
    $requestStmt->execute();
    $requestResult = $requestStmt->get_result();

    if ($requestResult->num_rows === 1) {
      $request = $requestResult->fetch_assoc();

      // Perform necessary validations and checks before accepting the request
      // ...

      // Create the images directory if it doesn't exist
      $destinationDirectory = 'images/';
      if (!file_exists($destinationDirectory)) {
        mkdir($destinationDirectory, 0777, true);
      }

      // Upload the image to the destination directory
      $uploadedFileName = basename($_FILES['photo']['name']);
      $uploadedFilePath = $destinationDirectory . $uploadedFileName;
      move_uploaded_file($_FILES['photo']['tmp_name'], $uploadedFilePath);

      // Insert the image and message into the completed_tasks table
      $insertStmt = $mysqli->prepare('INSERT INTO completed_tasks (politician_id, message, image) VALUES (?, ?, ?)');
      $insertStmt->bind_param('iss', $request['politician_id'], $request['message'], $uploadedFilePath);
      $insertStmt->execute();

      // Update the status of the request to 'Accepted'
      $updateStmt = $mysqli->prepare('UPDATE requests SET status = ? WHERE id = ?');
      $status = 'Accepted';
      $updateStmt->bind_param('si', $status, $requestId);
      $updateStmt->execute();
    }
  } elseif ($action === 'decline') {
    // Update the status of the request to 'Declined'
    $updateStmt = $mysqli->prepare('UPDATE requests SET status = ? WHERE id = ?');
    $status = 'Declined';
    $updateStmt->bind_param('si', $status, $requestId);
    $updateStmt->execute();
  }

  $requestStmt->close();
  $insertStmt->close();
  $updateStmt->close();
}

$mysqli->close();
