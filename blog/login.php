<?php include('config.php'); ?>
<?php include('includes/header.php'); ?>

<h2>Login</h2>
<form action="login.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <button type="submit" name="login">Login</button>
</form>

<?php
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found with that username";
    }
}
?>

<?php include('includes/footer.php'); ?>
