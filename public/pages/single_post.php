<?php
session_start();

require_once('../../src/db.php');
include('../../app/includes/header.php');
include './render_image.php';


if (!isset($_GET['postId'])) {
    echo "<p>❌ Inget inlägg valt.</p>";
    exit();
}

// GEt post if from url query
$postId = intval($_GET['postId']);

// Prepare and execute SQL
$sql = "SELECT post.*, user.username 
        FROM post 
        JOIN user ON post.userId = user.id 
        WHERE post.id = ?";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "i", $postId);
mysqli_stmt_execute($stmt);

$results = get_result($stmt);
mysqli_stmt_close($stmt);

// Check and display
if (empty($results)) {
    echo "<p>❌ Inlägget hittades inte.</p>";
    exit();
}

$post = $results[0];
?>
<div class="post-container">

    <aside
        class="back-support"><?php include('../../app/includes/info.php'); ?>
    </aside>
    <main class="centered">
        <div class="om-content" style="padding: 20px;">
            <h2><?= htmlspecialchars($post['title']) ?></h2>
            <?php render_images_for_post($post['id']); ?>

            <br>

            <p>
                <strong><?= htmlspecialchars($post['username']) ?></strong>
                wrote:</p>
            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            <small><?= htmlspecialchars($post['created']) ?></small>
        </div>
    </main>
</div>

<?php include('../../app/includes/footer.php'); ?>

