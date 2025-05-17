<?php
include('./app/includes/header.php');

include('./load_posts.php');

include('./render_image.php');

// Session + view logic
$loggedInUser = $_SESSION['user'] ?? null;
$isOwner = isset($loggedInUser);
$viewingUser = $isOwner ? $loggedInUser : null;

// Fallback to post author's username if not logged in
if (!$viewingUser && !empty($posts)) {
    $viewingUser = ['username' => $posts[0]['username'] ?? 'Unknown'];
}

?>

<main>
     <h2>
        <?php if ($isOwner): ?>
            Welcome, <?= htmlspecialchars($viewingUser['username']) ?>! Here are your posts:
        <?php else: ?>
            Posts by <?= htmlspecialchars($viewingUser['username']) ?>
        <?php endif; ?>
    </h2>


    <?php if (empty($posts)): ?>
        <div class="om-content">
            <p class=""><?= $isOwner ? "You haven't posted anything yet." : "This user hasn't posted anything yet." ?></p>
        </div>
    <?php else: ?>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li class="om-content ">
                    <strong><?= htmlspecialchars($post['title']) ?></strong>
                    <br>
                    <?php render_images_for_post($post['id']); ?>

                    <br>
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                    <br>
                    <small>Posted on
                        <?= htmlspecialchars($post['created']) ?>
                    </small><br><br>


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

