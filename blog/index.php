<?php include('config.php'); ?>
<?php include('includes/header.php'); ?>

<h2>Recent Posts</h2>
<?php
$sql = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username 
        FROM posts JOIN users ON posts.author_id = users.id 
        ORDER BY posts.created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<h3><a href='post.php?id={$row['id']}'>{$row['title']}</a></h3>";
        echo "<p>by {$row['username']} on {$row['created_at']}</p>";
        echo "<p>" . substr($row['content'], 0, 100) . "...</p>";
    }
} else {
    echo "No posts found";
}
?>

<?php include('includes/footer.php'); ?>
