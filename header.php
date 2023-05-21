<?php
// header.php

// header.php

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['user_id'])) {
  // Redirect to the appropriate login page based on the current file
  $currentPage = basename($_SERVER['PHP_SELF']);
  
  if ($currentPage === 'politicianDisplay.php') {
      header("Location: politicianLogin.php");
  } elseif ($currentPage === 'adminDisplay.php') {
      header("Location: adminLogin.php");
  } else {
      header("Location: login.php");
  }
  exit();
}

$activeUser = $_SESSION['user_name'];

?>

<div class="header">
  <a href="wall.php" style="text-decoration: none; color: #fff;">
    <h2>Reality Check</h2>
  </a>
  <div class="user">
    <i class="fas fa-user"></i>
    <span><?php echo $activeUser; ?></span>
    <div class="dropdown">
      <a href="#">Settings</a>
      <a href="logout.php">Logout</a>
      <a href="#">Update</a>
    </div>
  </div>
</div>
<style>
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    background-color: #3b5998;
    padding: 10px 20px;
    color: #fff;
  }

  .header h2 {
    margin: 0;
  }

  .header .user {
    display: flex;
    align-items: center;
    position: relative;
    cursor: pointer;
  }

  .header .user i {
    font-size: 24px;
    margin-right: 10px;
  }

  .header .user span {
    font-weight: bold;
  }

  .dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    display: none;
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    z-index: 1;
  }

  .dropdown a {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: #333;
  }

  .dropdown a:hover {
    background-color: #ddd;
  }

  .header .user:hover .dropdown {
    display: block;
  }
</style>
