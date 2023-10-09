<?php
// Establish a database connection
$servername = "localhost";
$username = "test";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the form
$title = $_POST['title'];
$content = $_POST['content'];

// Insert data into the database
$sql = "INSERT INTO blog_posts (title, content) VALUES ('$title', '$content')";

if ($conn->query($sql) === TRUE) {
    echo "Blog post created successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
