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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletePostId'])) {
    $deletePostId = intval($_POST['deletePostId']);
    // Optional: Confirm the post belongs to the user before deleting
    $post = get_single_post($deletePostId);
    if ($post && $post['userId'] === $userId) {
        delete_post($deletePostId);
        // Redirect to prevent resubmission on refresh
        header("Location: content.php");
        exit();
    } else {
        echo "<p>❌ You don't have permission to delete this post.</p>";
    }
}

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
                    <?php
                    // Fetch the images associated with the post
                    if (isset($post['id'])) {
                        $images = get_images($post['id']);
                        if ($images):
                            // Loop through all images and display them
                            foreach ($images as $image): ?>
                                <img
                                src="./uploads/<?= htmlspecialchars($image['filename']) ?>" alt="<?= htmlspecialchars($image['description']) ?>" style="max-width: 300px; margin-top: 10px;">
                            <?php endforeach;
                        endif;
                    }
                    ?>

                    <br>
                    <br>
                    <?php if (!empty($post['id'])): ?>
                        <a href="upload.php?postId=<?= urlencode($post['id']) ?>" class="btn-g">Edit</a>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                            <input type="hidden" name="deletePostId" value="<?= $post['id'] ?>">
                            <button type="submit" class="btn-r">Delete</button>
                        </form>
                    <?php else: ?>
                        <span class="error">Post ID is missing!</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</main>

