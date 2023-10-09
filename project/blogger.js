const blogPostForm = document.getElementById('blog-post-form');
const titleInput = document.getElementById('title');
const contentInput = document.getElementById('content');
const addButton = document.getElementById('add-button');
const blogPostList = document.getElementById('blog-post-list');
const updateDelete = document.getElementById('update-delete');
const newTitleInput = document.getElementById('new-title');
const newContentInput = document.getElementById('new-content');
const updateButton = document.getElementById('update-button');
const deleteButton = document.getElementById('delete-button');

const blogPosts = [];

// Function to add a new blog post
addButton.addEventListener('click', () => {
  const newTitle = titleInput.value.trim();
  const newContent = contentInput.value.trim();
  if (newTitle && newContent) {
    const newPost = { title: newTitle, content: newContent };
    blogPosts.push(newPost);
    updateBlogPostList();
    titleInput.value = '';
    contentInput.value = '';
  }
});

// Function to update a blog post
updateButton.addEventListener('click', () => {
  const selectedIndex = blogPostList.selectedIndex;
  if (selectedIndex !== -1) {
    const newTitle = newTitleInput.value.trim();
    const newContent = newContentInput.value.trim();
    if (newTitle && newContent) {
      blogPosts[selectedIndex].title = newTitle;
      blogPosts[selectedIndex].content = newContent;
      updateBlogPostList();
      newTitleInput.value = '';
      newContentInput.value = '';
    }
  }
});

// Function to delete a blog post
deleteButton.addEventListener('click', () => {
  const selectedIndex = blogPostList.selectedIndex;
  if (selectedIndex !== -1) {
    blogPosts.splice(selectedIndex, 1);
    updateBlogPostList();
    newTitleInput.value = '';
    newContentInput.value = '';
  }
});

// Function to update the blog post list
function updateBlogPostList() {
  blogPostList.innerHTML = '';
  blogPosts.forEach((post) => {
    const option = document.createElement('option');
    option.text = post.title;
    blogPostList.appendChild(option);
  });
}
