<?php
include('./app/includes/header.php');
// include('./app/includes/content.php') ;

require_once('db.php');
$data = nyheter();
$users = $data['users'];
$posts = $data['posts'];
?>

<h2>Senaste inlägg</h2>
<?php foreach ($posts as $post): ?>
    <article>
    <h3><?= htmlspecialchars($post['title']) ?></h3>
    <small>Skapad: <?= htmlspecialchars($post['created']) ?></small>
    <br>
    <a href="single_post.php?postId=<?= urlencode($post['id']) ?>" class="btn-y">Read more</a>
</article>
<?php endforeach; ?>

<h2>Användare</h2>
<ul>
    <?php foreach ($users as $user): ?>
        <li><?= htmlspecialchars($user['username']) ?></li>
    <?php endforeach; ?>
</ul>
