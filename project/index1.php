<!DOCTYPE html>
<html>
<head>
  <title>Blog Writing Website</title>
  <style>
    /* CSS styles for the website */
      body {
      font-family: Arial, sans-serif;
      background-color: #fafafa;
      color: #333;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
    }

    h1 {
      text-align: center;
    }

    .blog-card {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .blog-card h2 {
      font-size: 20px;
      margin-bottom: 10px;
    }

    .blog-card p {
      margin-bottom: 10px;
    }

    .blog-card .like-btn,
    .blog-card .comment-btn,
    .blog-card .share-btn {
      color: #333;
      cursor: pointer;
      margin-right: 10px;
      transition: color 0.3s ease;
    }

    .blog-card .like-btn:hover,
    .blog-card .comment-btn:hover,
    .blog-card .share-btn:hover {
      color: #000;
    }

    .comment-section {
      margin-top: 20px;
    }

    .comment-section input[type="text"] {
      width: 80%;
      padding: 5px;
      border: 1px solid #ddd;
      border-radius: 4px;
      margin-right: 10px;
    }

    .comment-section button {
      padding: 5px 10px;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .comment-section button:hover {
      background-color: #000;
    }
    /* ... */
  </style>

  <script>
    // JavaScript code for counting likes and adding comments
    function like(blogId) {
      // Send an AJAX request to the server to handle the like functionality
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
          var likeCount = document.getElementById('like-count-' + blogId);
          var liked = document.getElementById('like-btn-' + blogId).classList.contains('liked');

          if (liked) {
            // User has already liked the blog
            likeCount.innerText = parseInt(likeCount.innerText) - 1;
            document.getElementById('like-btn-' + blogId).classList.remove('liked');
          } else {
            // User is liking the blog for the first time
            likeCount.innerText = parseInt(likeCount.innerText) + 1;
            document.getElementById('like-btn-' + blogId).classList.add('liked');
          }
        }
      };
      xhttp.open("GET", "like.php?id=" + blogId, true);
      xhttp.send();
    }

    function addComment(blogId) {
      // Send an AJAX request to the server to handle adding a comment
      var commentInput = document.getElementById('comment-input-' + blogId);
      var comment = commentInput.value;

      if (comment.trim() !== '') {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState === 4 && this.status === 200) {
            var commentSection = document.getElementById('comment-section-' + blogId);
            var commentElement = document.createElement('p');
            commentElement.innerText = comment;
            commentSection.appendChild(commentElement);
            commentInput.value = '';
          }
        };
        xhttp.open("POST", "comment.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("blogId=" + blogId + "&comment=" + comment);
      }
    }
  </script>
</head>
<body>
  <div class="container">
    <h1>Welcome to the Blog Writing Website</h1>

    <?php
    include 'connect.php';

    // Retrieve blogs from the database
    $sql = "SELECT * FROM blogs";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $blogId = $row['id'];
        $title = $row['title'];
        $content = $row['content'];

        // Count the number of likes for the blog
        $sql = "SELECT COUNT(*) AS like_count FROM likes WHERE blog_id = $blogId";
        $likeResult = $conn->query($sql);
        $likeCount = $likeResult->fetch_assoc()['like_count'];

        // Retrieve comments for the blog
        $sql = "SELECT * FROM comments WHERE blog_id = $blogId";
        $commentResult = $conn->query($sql);
        ?>

        <!-- Blog -->
        <div class="blog-card">
          <h2><?php echo $title; ?></h2>
          <p><?php echo $content; ?></p>
          <div>
            <span id="like-count-<?php echo $blogId; ?>"><?php echo $likeCount; ?></span>
            <span class="like-btn" id="like-btn-<?php echo $blogId; ?>" onclick="like(<?php echo $blogId; ?>)">Like</span>
            <span class="comment-btn">Comment</span>
            <span class="share-btn">Share</span>
          </div>
          <div class="comment-section">
            <input type="text" id="comment-input-<?php echo $blogId; ?>" placeholder="Add a comment">
            <button onclick="addComment(<?php echo $blogId; ?>)">Post</button>
          </div>
          <div id="comment-section-<?php echo $blogId; ?>">
            <?php
            if ($commentResult->num_rows > 0) {
              while ($commentRow = $commentResult->fetch_assoc()) {
                echo "<p>" . $commentRow['comment'] . "</p>";
              }
            }
            ?>
          </div>
        </div>

        <?php
      }
    }

    // Close the database connection
    $conn->close();
    ?>

  </div>
   <!-- Blog 1 -->
    <div class="blog-card">
      <h2>Blog Title 1</h2>
      <p>Blog content goes here...</p>
      <div>
        <span id="like-count-1">0</span>
        <span class="like-btn" id="like-btn-1" onclick="like(1)">Like</span>
        <span class="comment-btn">Comment</span>
        <span class="share-btn">Share</span>
      </div>
      <div class="comment-section">
        <input type="text" id="comment-input-1" placeholder="Add a comment">
        <button onclick="addComment(1)">Post</button>
      </div>
      <div id="comment-section-1">
        <!-- Existing comments will be dynamically added here -->
      </div>
    </div>

    <!-- Blog 2 -->
    <div class="blog-card">
      <h2>Blog Title 2</h2>
      <p>Blog content goes here...</p>
      <div>
        <span id="like-count-2">0</span>
        <span class="like-btn" id="like-btn-2" onclick="like(2)">Like</span>
        <span class="comment-btn">Comment</span>
        <span class="share-btn">Share</span>
      </div>
      <div class="comment-section">
        <input type="text" id="comment-input-2" placeholder="Add a comment">
        <button onclick="addComment(2)">Post</button>
      </div>
      <div id="comment-section-2">
        <!-- Existing comments will be dynamically added here -->
      </div>
    </div>

    <!-- Add more blogs here -->

  </div>
</body>
</html>
