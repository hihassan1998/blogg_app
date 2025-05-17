<?php
include('./app/includes/header.php');
require 'db.php';

$loggedInUser = $_SESSION['user'] ?? null;
$viewingUser = null;

// Determine if viewing another user's posts
if (isset($_GET['userId'])) {
    $viewingUserId = intval($_GET['userId']);
    $viewingUser = get_user_by_id($viewingUserId);
    if (!$viewingUser) {
        echo "<p>User not found.</p>";
        exit();
    }
} elseif ($loggedInUser) {
    $viewingUser = $loggedInUser;
    $viewingUserId = $loggedInUser['id'];
} else {
    header("Location: login.php");
    exit();
}

$isOwner = $loggedInUser && ($loggedInUser['id'] === $viewingUserId);
$posts = get_user_posts($viewingUserId);

// Handle deletion if owner
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletePostId']) && $isOwner) {
    $deletePostId = intval($_POST['deletePostId']);
    $post = get_single_post($deletePostId);
    if ($post && $post['userId'] === $viewingUserId) {
        delete_post($deletePostId);
        header("Location: content.php");
        exit();
    } else {
        echo "<p>❌ You don't have permission to delete this post.</p>";
    }
}
?>

<main>
    <h2>
    <?= $isOwner ? "Welcome, " . htmlspecialchars($loggedInUser['username']) . "! Here are your posts:" : "Posts by " . htmlspecialchars($viewingUser['username']) ?>
</h2>


    <?php if (empty($posts)): ?>
        <div class="om-content">
            <p class="om-content"><?= $isOwner ? "You haven't posted anything yet." : "This user hasn't posted anything yet." ?></p>
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
                    </small><br><br>
                    <?php
                    $images = get_images($post['id']);
                    // $images = get_images($post['userId']);
                    if ($images):
                        foreach ($images as $image):
                            echo "<pre>DEBUG filename: ";
                            var_dump($image['filename']);
                            echo "</pre>";
                            ?>
                            <img class="centered" src="./uploads/<?= htmlspecialchars($image['filename']) ?>" alt="<?= htmlspecialchars($image['description']) ?>" style="max-width: 250px; margin-top: 10px;">
                        <?php
                        endforeach;
                    else:
                        echo "<p><em>DEBUG: No images found for post ID " . htmlspecialchars($post['id']) . ".</em></p>";
                    endif;
                    ?>


                    <br><br>
                    <a href="single_post.php?postId=<?= urlencode($post['id']) ?>" class="btn-y">Read more</a>

                    <?php if ($isOwner): ?>
                        <a href="upload.php?postId=<?= urlencode($post['id']) ?>" class="btn-g">Edit</a>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                            <input type="hidden" name="deletePostId" value="<?= $post['id'] ?>">
                            <button type="submit" class="btn-r">Delete</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</main>

