/ JavaScript code goes here
// You can use this script tag or link an external JavaScript file

// Example code to fetch and display blog posts dynamically on the homepage
const postsContainer = document.getElementById('posts-container');

// Fetch blog posts from an API or a backend
fetch('https://api.example.com/posts')
  .then(response => response.json())
  .then(posts => {
    // Create HTML elements for each blog post
    posts.forEach(post => {
      const postElement = document.createElement('div');
      postElement.classList.add('post');

      const titleElement = document.createElement('h3');
      titleElement.textContent = post.title;

      const contentElement = document.createElement('p');
      contentElement.textContent = post.content;

      // Add event listener to navigate to the blog post page when clicked
      postElement.addEventListener('click', () => {
        // Pass the post ID as a URL parameter to the blog post page
        window.location.href = `blog_post.html?id=${post.id}`;
      });

      postElement.appendChild(titleElement);
      postElement.appendChild(contentElement);
      postsContainer.appendChild(postElement);
    });
  })
  .catch(error => {
    console.error('Error fetching posts:', error);
  });

// Example code to handle form submission for creating a new post
const newPostForm = document.getElementById('new_post-form');

newPostForm.addEventListener('submit', event => {
  event.preventDefault(); // Prevent the default form submission

  const title = document.getElementById('title').value;
  const content = document.getElementById('content').value;

  // Send a POST request to the backend API to create the new post
  fetch('https://api.example.com/posts', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ title, content })
  })
    .then(response => response.json())
    .then(post => {
      // Redirect to the blog post page for the newly created post
      window.location.href = `blogpost.html?id=${post.id}`;
    })
    .catch(error => {
      console.error('Error creating post:', error);
    });
});

// Example code to fetch and display a specific blog post on the blog post page
const urlParams = new URLSearchParams(window.location.search);
const postId = urlParams.get('id');

if (postId) {
  const postTitle = document.getElementById('post-title');
  const postContent = document.getElementById('post-content');

  // Fetch the specific blog post from the backend
  fetch(`https://api.example.com/posts/${postId}`)
    .then(response => response.json())
    .then(post => {
      postTitle.textContent = post.title;
      postContent.textContent = post.content;
    })
    .catch(error => {
      console.error('Error fetching post:', error);
    });
}