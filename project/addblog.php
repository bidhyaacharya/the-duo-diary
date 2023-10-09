
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog Post</title>
    <!-- Include the styles.css file -->
   
</head>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

// Create a connection to the existing database
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data and sanitize inputs
    $title = $_POST["title"];
    $content = $_POST["content"];
    $photo = $_FILES["photo"]["name"];


    // Validate Name: Ensure it contains only letters, spaces, and hyphens
    if (!preg_match("/^[a-zA-Z\s\-]+$/", $title)) {
        die("Please enter a valid title. ");
    }

    // Validate Photo: Ensure it is a valid image file with extensions JPG, JPEG, PNG, or GIF
    $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
    $photoExtension = strtolower(pathinfo($photo, PATHINFO_EXTENSION));
    if (!in_array($photoExtension, $allowedExtensions)) {
        die("Please select a valid photo (JPG, JPEG, PNG, or GIF).");
    }

    // Handle the uploaded photo
    $targetDir = "photos/";
    $targetFile = $targetDir . basename($_FILES["photo"]["name"]);
     // $targetDir is the directory path where we want to store the uploaded photo, and $_FILES["photo"]["name"] is the name of the uploaded photo file as received from the client-side form. The basename() function is used to extract the filename part from the complete path.
     

    // Ensure the "photos" directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    // The mkdir() function is used to create a directory in PHP. In the context of the code, mkdir($targetDir, 0777, true) is used to create the "photos" directory if it doesn't already exist.Here's what each parameter means:                $targetDir: The first parameter of mkdir() is the path of the directory that you want to create. In this case, $targetDir holds the path where you want to store the uploaded photos, which is set to "photos/".                      0777: The second parameter of mkdir() is the permissions for the newly created directory. It's an octal value representing the permission mode. In this case, 0777 means full read, write, and execute permissions for all users (owner, group, and others).                   true: The third parameter of mkdir() is a boolean that indicates whether to create parent directories if they don't exist. When set to true, PHP will recursively create any parent directories that are missing. In this case, true ensures that if the "photos" directory does not exist, it will be created along with any intermediate directories as needed.

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
        // $_FILES["photo"]["tmp_name"]: When a file is uploaded through an HTML form, PHP stores the uploaded file in a temporary location on the server. The $_FILES superglobal is an associative array that holds information about the uploaded files. $_FILES["photo"]["tmp_name"] refers to the temporary location where the uploaded file is stored.

        // Insert data into the "student" table
        $sql = "INSERT INTO data (title, content, photo) VALUES ('$title', '$content', '$targetFile')";

        if ($conn->query($sql) === TRUE) {
            echo "Data updated successfully.";
                $conn->close();

                // Redirect to read_data.php
                header("Location: dashboard.php");
                exit;
        } else {
            echo "Error inserting data: " . $conn->error;
        }
    } else {
        echo "Error uploading photo.";
    }
}

$conn->close();
?>
