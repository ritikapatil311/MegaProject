<?php
session_start();

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mysqli = new mysqli('localhost', 'root', '', 'rc');

    $stmt = $mysqli->prepare('INSERT INTO posts (user_id, image, caption, pincode, location) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('issss', $user_id, $image, $caption, $pincode, $location);

    $user_id = $_SESSION['user_id'];

    $fileCount = count($_FILES['image']['name']);
    for ($i = 0; $i < $fileCount; $i++) {
        $targetDirectory = 'uploads/';
        $targetFile = $targetDirectory . basename($_FILES['image']['name'][$i]);
        move_uploaded_file($_FILES['image']['tmp_name'][$i], $targetFile);

        $caption = $_POST['caption'][$i];
        $image = $targetFile;
        $pincode = $_POST['pincode'];
        $location = $_POST['location'];

        // Execute the statement
        $stmt->execute();
    }

    $stmt->close();
    $mysqli->close();

    $successMessage = 'Image successfully uploaded!';
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Image Upload</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
    }

    .upload-form {
      max-width: 400px;
      margin: 0 auto;
      border: 1px solid #ddd;
      padding: 20px;
      background-color: #f9f9f9;
    }

    .upload-form input[type="file"],
    .upload-form textarea,
    .upload-form input[type="text"] {
      width: 100%;
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
      resize: vertical;
    }

    .upload-form button {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      float: right;
    }

    .upload-form button:hover {
      background-color: #45a049;
    }

    .success-message {
      text-align: center;
      background-color: #d4edda;
      color: #155724;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #c3e6cb;
      border-radius: 4px;
    }

    .go-back-button {
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>

  <div class="upload-form">
    <?php if ($successMessage) { ?>
      <div class="success-message">
        <?php echo $successMessage; ?>
      </div>
      <div class="go-back-button">
        <a href="wall.php">Go Back to Wall Page</a>
      </div>
    <?php } else { ?>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="image[]" accept="image/*" multiple required>
        <textarea name="caption[]" placeholder="Enter a caption..." required></textarea>
        <input type="text" name="pincode" placeholder="Enter a pincode..." required>
        <textarea name="location" placeholder="Enter the location..."></textarea>
        <button type="submit">Upload</button>
      </form>
    <?php } ?>
  </div>
</body>
</html>
