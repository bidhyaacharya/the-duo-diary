
<!DOCTYPE html>
<html>
<head>
    <title>Student Management System</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <h1>Student Management System</h1>
    <div class="navbar">
        
        <a href="student_form.php">Add Data</a>
        <a href="logout.php">Logout</a> <!-- Add this link -->
    </div>
    <br><br>

    
    
    <!-- Display the list of students from the database in a table -->
    <h2>Student List:</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Photo</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php
        // Fetch data from the database
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

        // SELECT query to fetch data from the "student" table
        $sql = "SELECT * FROM data";

        // Execute the query
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["content"] . "</td>";
                echo "<td><img src='" . $row["photo"] . "' width='100'></td>";
                echo "<td>
                    <form action='edit_student_data.php?id=" . $row["id"] . "' method='post'>
                        <input type='submit' value='Edit'>
                    </form>
                  </td>";
                echo "<td><form action='delete_student_data.php' method='post'>
                          <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                          <input type='submit' value='Delete'>
                      </form></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found.</td></tr>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </table>
    <!-- JavaScript code to show the prompt for success message -->
<script>



</body>
</html>