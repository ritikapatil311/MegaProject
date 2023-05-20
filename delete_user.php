<?php
// Database connection
$mysqli = new mysqli('localhost', 'root', '', 'rc');

// Check if the connection was successful
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    exit();
}

// Check if the user ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the user's posts first
    $deletePostsStmt = $mysqli->prepare('DELETE FROM posts WHERE user_id = ?');
    $deletePostsStmt->bind_param('i', $id);
    $deletePostsStmt->execute();
    $deletePostsStmt->close();

    // Delete the user from the database
    $deleteUserStmt = $mysqli->prepare('DELETE FROM users WHERE uid = ?');
    $deleteUserStmt->bind_param('i', $id);
    $deleteUserStmt->execute();

    // Check if the user was deleted successfully
    if ($deleteUserStmt->affected_rows > 0) {
        echo 'User deleted successfully';
    } else {
        echo 'Failed to delete user';
    }

    $deleteUserStmt->close();
}

// Close database connection
$mysqli->close();
?>
