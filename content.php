<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$currentUser = $_SESSION['user'];
$userId = $currentUser['id'];
echo $userId;
$posts = get_user_posts($userId);
?>

<h2>Welcome, <?= htmlspecialchars($currentUser['username']) ?>! Here are your posts:</h2>

<?php if (empty($posts)): ?>
    <p>You haven't posted anything yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <strong><?= htmlspecialchars($post['title']) ?></strong><br>
                <strong><?= htmlspecialchars($post['userId']) ?></strong><br>
                <?= nl2br(htmlspecialchars($post['content'])) ?><br>
                <small>Posted on <?= htmlspecialchars($post['created_at']) ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
