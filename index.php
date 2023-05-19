<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $mysqli = new mysqli('localhost', 'root', '', 'rc');

    $stmt = $mysqli->prepare('INSERT INTO posts (user_id, image, caption) VALUES (?, ?, ?)');
    $stmt->bind_param('iss', $user_id, $image, $caption);

    $user_id = $_SESSION['user_id'];

    $fileCount = count($_FILES['image']['name']);
    for ($i = 0; $i < $fileCount; $i++) {
        $targetDirectory = 'uploads/';
        $targetFile = $targetDirectory . basename($_FILES['image']['name'][$i]);
        move_uploaded_file($_FILES['image']['tmp_name'][$i], $targetFile);

        $caption = $_POST['caption'][$i];
        $image = $targetFile;

        // Execute the statement
        $stmt->execute();
    }

    $stmt->close();
    $mysqli->close();

    header('Location: display.php');
    exit();
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
    .upload-form textarea {
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
  </style>
</head>
<body>
<?php include 'header.php'; ?>

  <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST') { ?>
    <div class="upload-form">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="image[]" accept="image/*" multiple required>
        <textarea name="caption[]" placeholder="Enter a caption..." required></textarea>
        <button type="submit">Upload</button>
      </form>
    </div>
  <?php } else { ?>
    <div class="upload-success">
      <p>Upload successful! Redirecting to the display page...</p>
    </div>
    <script>
      setTimeout(function() {
        window.location.href = 'display.php';
      }, 2000);
    </script>
  <?php } ?>
</body>
</html>
