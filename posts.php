<?php
include('./app/includes/header.php') ;

require_once('db.php');

$posts = get_posts();
?>
<head>
    <meta charset="UTF-8">
    <title>Inlägg</title>
</head>

    <h1>Alla inlägg</h1>

    <?php if (empty($posts)): ?>
        <p>Inga inlägg hittades.</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div class="om-content" style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                <p><strong><?= htmlspecialchars($user['username']) ?></strong> skrev:</p>
                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                <small><?= htmlspecialchars($post['created']) ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php include('./app/includes/footer.php') ?>