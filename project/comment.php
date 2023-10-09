<?php
include 'connect.php';

// Get the blog ID and comment from the POST data
$blogId = $_POST['blogId'];
$comment = $_POST['comment'];

// Insert the comment into the database
$sql = "INSERT INTO comments (blog_id, comment) VALUES ($blogId, '$comment')";
if ($conn->query($sql) === TRUE) {
  echo "Comment added";
} else {
  echo "Error adding comment: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
