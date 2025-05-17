<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

?>

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <?php include('./app/includes/header.php') ?>
</head>
<body>
<main>
    <h1>Welcome, <?= htmlspecialchars($user['username']) ?>!</h1>
    <p>This is the admin dashboard.</p>

    <!-- Example admin options -->
    <ul>
        <li><a href="posts.php">View all posts</a></li>
        <li><a href="manage_posts.php">Manage Posts</a></li>
        <li><a href="content.php">My Content</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</main>

<?php include('./app/includes/footer.php') ?>
</body>
</html>
