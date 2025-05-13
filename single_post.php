<?php
require_once('db.php');
include('./app/includes/header.php');

if (!isset($_GET['postId'])) {
    echo "<p>❌ Inget inlägg valt.</p>";
    exit();
}

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
        class="back-support"><?php include('./info.php'); ?>
    </aside>
    <main class="">
        <div class="om-content" style="padding: 20px;">
            <h2><?= htmlspecialchars($post['title']) ?></h2>
            <p>
                <strong><?= htmlspecialchars($post['username']) ?></strong>
                skrev:</p>
            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            <small><?= htmlspecialchars($post['created']) ?></small>
        </div>
    </main>
</div>

<?php include('./app/includes/footer.php'); ?>

