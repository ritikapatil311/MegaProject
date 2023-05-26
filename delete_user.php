<?php

$mysqli = new mysqli('localhost', 'root', '', 'rc');


if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    exit();
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $deletePostsStmt = $mysqli->prepare('DELETE FROM posts WHERE user_id = ?');
    $deletePostsStmt->bind_param('i', $id);
    $deletePostsStmt->execute();
    $deletePostsStmt->close();

   
    $deleteUserStmt = $mysqli->prepare('DELETE FROM users WHERE uid = ?');
    $deleteUserStmt->bind_param('i', $id);
    $deleteUserStmt->execute();

    
    if ($deleteUserStmt->affected_rows > 0) {
        echo 'User deleted successfully';
    } else {
        echo 'Failed to delete user';
    }

    $deleteUserStmt->close();
}


$mysqli->close();
?>
