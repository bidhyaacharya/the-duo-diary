<?php
// Establish database connection
$conn = new mysqli('localhost', 'root', '', 'blod_db');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['username'])) {
  $username = $_POST['username'];
  $query = "SELECT * FROM users WHERE username = '$username'";

  $result = $conn->query($query);
  if ($result && $result->num_rows > 0) {
    echo 'taken';
  } else {
    echo 'available';
  }
}

// Close database connection
$conn->close();
?>
