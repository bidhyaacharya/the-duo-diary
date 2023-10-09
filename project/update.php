

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Blog Post</title>
    <link rel="stylesheet" type="text/css" href="./css/styles.css"> <!-- Include the styles.css file -->
    <style type="text/css">
        /*form css*/
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        img{
            width: 400px;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        h1 {
            text-align: left;
            padding: 10px;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $student_id = intval($_GET['id']); // Convert the ID to an integer for security

            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "project";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['submit'])){
                    // Validate and retrieve the updated student data from the form fields
                    $updated_title = isset($_POST['updated_title']) ? trim($_POST['updated_title']) : '';
                    $updated_content = isset($_POST['updated_content']) ? trim($_POST['updated_content']) : '';

                    // Validate required fields
                    if (empty($updated_title) || empty($updated_content)) {
                        echo "Title and Content are required fields.";
                    }  else {
                        // Check if a new photo is uploaded
                        if ($_FILES['new_photo']['error'] === 0) {
                            $new_photo_tmp = $_FILES['new_photo']['tmp_name'];
                            $new_photo_name = $_FILES['new_photo']['name'];
                            $new_photo_destination = "photos/" . $new_photo_name;

                            // Move the uploaded photo to the "uploads" directory
                            if (move_uploaded_file($new_photo_tmp, $new_photo_destination)) {
                                // UPDATE query to update the data in the "student" table with the new photo path
                                $sql = "UPDATE data SET title='$updated_title', content='$updated_content', photo='$new_photo_destination' WHERE id='$data_id'";
                            } else {
                                echo "Error uploading photo.";
                            }
                        } else {
                            // UPDATE query to update the data in the "student" table without changing the photo path
                            $sql = "UPDATE data SET title='$updated_title', content='$updated_content' WHERE id='$data_id'";
                        }

                        // After the query is executed successfully, display the success message and redirect
                        if (!empty($sql) && $conn->query($sql) === TRUE) {
                            echo "Data updated successfully.";
                            $conn->close();

                            // Redirect to dashboard.php
                            header("Location: blog_post.html");
                            exit;
                        } else {
                            echo "Error updating data: " . $conn->error;
                        }
                    }
                }
            }

            $sql = "SELECT * FROM data WHERE id = $data_id";
            $result = $conn->query($sql);

            if ($result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();
        ?>
                <h1>The Duo Diary</h1>
                <div class="navbar">
                    <a href="blog_post.html">Reader</a>
                    <a href="new_post.html">Blogger</a>
                    <a href="logout.html">Logout</a>
                </div>
                <h2>Update Blog Post</h2>
                <form action="update_data_data.php?id=<?php echo $data_id; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="update_id" value="<?php echo $row["id"]; ?>">
                    <div class="form-group">
                        <label for="title">title:</label>
                        <input type="text" name="updated_title" value="<?php echo $row["title"]; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Content:</label>
                        <input type="text" name="updated_content" value="<?php echo $row["content"]; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="current_photo">Current Photo:</label>
                        <img src="<?php echo $row["photo"]; ?>" alt="Current Photo">
                    </div>
                    <div class="form-group">
                        <label for="new_photo">New Photo:</label>
                        <input type="file" name="new_photo">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Update">
                    </div>
                </form>
        <?php
            } else {
                echo "Blog Post not found.";
            }

            $conn->close();
        } else {
            echo "Invalid request.";
        }
        ?>
    </div>
</body>
</html>
