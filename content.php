<?php
include('./app/includes/header.php');

require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$currentUser = $_SESSION['user'];
$userId = $currentUser['id'];
// echo $userId;
$posts = get_user_posts($userId);
?>
<main>

    <h2>Welcome,
        <?= htmlspecialchars($currentUser['username']) ?>
        ! Here are your posts:</h2>


    <?php if (empty($posts)): ?>

        <div class="om-content">
            <p class="om-content">You haven't posted anything yet.</p>
        </div>

    <?php else: ?>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li class="om-content">
                    <strong><?= htmlspecialchars($post['title']) ?></strong><br>
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                    <br>
                    <small>Posted on
                        <?= htmlspecialchars($post['created']) ?>
                    </small>
                    <br>
                    <br>
                    <?php if (!empty($post['id'])): ?>
                        <a href="upload.php?postId=<?= urlencode($post['id']) ?>" class="btn-g">Edit</a>
                    <?php else: ?>
                        <span class="error">Post ID is missing!</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</main>

