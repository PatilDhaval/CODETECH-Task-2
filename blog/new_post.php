<?php include('config.php'); ?>
<?php include('includes/header.php'); ?>

<h2>New Post</h2>
<form action="new_post.php" method="post">
    <label for="title">Title:</label>
    <input type="text" name="title" required>
    <label for="content">Content:</label>
    <textarea name="content" required></textarea>
    <button type="submit" name="submit_post">Post</button>
</form>

<?php
if (isset($_POST['submit_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id'];

    $sql = "INSERT INTO posts (title, content, author_id) VALUES ('$title', '$content', $author_id)";
    if ($conn->query($sql) === TRUE) {
        echo "Post created successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<?php include('includes/footer.php'); ?>
