<?php
include('./app/includes/header.php');
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
</head>
<body>
    <main class="main">
        <h1>Admin dashboard</h1>
                    <div class="contactlayout">
                <div class="part">
                    <div>
                        <img style="max-width: 250px;" src="./public/img/logo/blog_icon.png" alt="">
                    </div>
                </div>
                <div class="part">
                    <h1 class="green-font special-heading"> <b>Välkommen <?= htmlspecialchars($user['username']) ?>!</b></h1>
                    <h1 class="blue-font special-heading"><b>Welcome <?= htmlspecialchars($user['username']) ?>! </b></h1>
                    <h1 class="yellow-font special-heading"><b>Salam <?= htmlspecialchars($user['username']) ?>! </b></h1>
                </div>
            </div>
        <div class="back-support">

            <h1>Welcome,
                <?= htmlspecialchars($user['username']) ?>
                !</h1>
            <p>This is the admin dashboard.</p>
            <p>You are a menber of this community since: 
                <?= htmlspecialchars($user['created']) ?>
                !</p>

            <!-- admin options -->
            <ul>
                <li><a href="posts.php">View all posts</a></li>
                <li><a href="content.php">VIew and manage my blogs</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </main>

    <?php include('./app/includes/footer.php') ?>
</body></html>

