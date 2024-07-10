<?php include('config.php'); ?>
<?php include('includes/header.php'); ?>

<?php
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT posts.title, posts.content, posts.created_at, users.username 
            FROM posts JOIN users ON posts.author_id = users.id 
            WHERE posts.id = $post_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
        echo "<h2>{$post['title']}</h2>";
        echo "<p>by {$post['username']} on {$post['created_at']}</p>";
        echo "<p>{$post['content']}</p>";

        echo "<h3>Comments</h3>";
        $sql = "SELECT comments.content, comments.created_at, users.username 
                FROM comments JOIN users ON comments.user_id = users.id 
                WHERE comments.post_id = $post_id 
                ORDER BY comments.created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<p><strong>{$row['username']}</strong>: {$row['content']} ({$row['created_at']})</p>";
            }
        } else {
            echo "No comments found";
        }

        if (isset($_SESSION['user_id'])) {
            echo "<form action='post.php?id=$post_id' method='post'>
                    <textarea name='comment' required></textarea>
                    <button type='submit' name='submit_comment'>Comment</button>
                  </form>";
        } else {
            echo "<p><a href='login.php'>Log in</a> to comment</p>";
        }

        if (isset($_POST['submit_comment'])) {
            $comment = $_POST['comment'];
            $user_id = $_SESSION['user_id'];

            $sql = "INSERT INTO comments (post_id, user_id, content) VALUES ($post_id, $user_id, '$comment')";
            if ($conn->query($sql) === TRUE) {
                header("Location: post.php?id=$post_id");
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "Post not found";
    }
} else {
    echo "Invalid post ID";
}
?>

<?php include('includes/footer.php'); ?>
