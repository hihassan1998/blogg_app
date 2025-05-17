<?php
include('../../app/includes/header.php');
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
<main class="main">
    <div class="contactlayout">
        <div class="part">
            <div>
                <img style="max-width: 250px;" src="../../public/img/logo/blog_icon.png" alt="">
            </div>
        </div>
        <div class="part">
            <h1 class="blue-font">
                <b>Welcome
                    <?= htmlspecialchars($user['username']) ?>
                    !
                </b>
            </h1>
        </div>
    </div>
    <div class="om-content">

        <h1>Welcome to the admin dashboard !</h1>
        <h3>You are a menber of this community since:
            <?= htmlspecialchars($user['created']) ?>
            !</h3>

    </div>
    <div
        class="om-content">

        <!-- admin options -->
        <ol class="">
            <strong>

                <li>
                    <a href="posts.php">View all posts</a>
                </li>
                <li>
                    <a href="content.php">VIew and manage my blogs</a>
                </li>
                <li>
                    <a href="upload.php">Create blogs</a>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </strong>
        </ol>
    </div>
</main>


<?php include('../../app/includes/footer.php') ?>

