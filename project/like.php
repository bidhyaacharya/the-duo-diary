<?php
include 'connect.php';

// Get the blog ID from the query parameter
$blogId = $_GET['id'];

// Get the user's IP address
$userIp = $_SERVER['REMOTE_ADDR'];

// Check if the user has already liked the blog
$sql = "SELECT * FROM likes WHERE blog_id = $blogId AND user_ip = '$userIp'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // User has already liked the blog, so delete the like
  $sql = "DELETE FROM likes WHERE blog_id = $blogId AND user_ip = '$userIp'";
  if ($conn->query($sql) === TRUE) {
    echo "Like removed";
  } else {
    echo "Error removing like: " . $conn->error;
  }
} else {
  // User is liking the blog for the first time, so insert the like
  $sql = "INSERT INTO likes (blog_id, user_ip) VALUES ($blogId, '$userIp')";
  if ($conn->query($sql) === TRUE) {
    echo "Liked";
  } else {
    echo "Error liking blog: " . $conn->error;
  }
}

// Close the database connection
$conn->close();
?>
