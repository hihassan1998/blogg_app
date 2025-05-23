<?php
session_start();

include('../../app/includes/header.php');
// include('./app/includes/content.php') ;

require_once('../../src/db.php');

$posts = get_all_posts();
?>
<head>
    <meta charset="UTF-8">
    <title>Blogs</title>
</head>

<h1>All Posts</h1>
<div class="post-container">
    <aside
        class="back-support"><?php include('../../app/includes/menu.php'); ?>
    </aside>

    <main>


        <?php if (empty($posts)): ?>
            <p>Inga inlägg hittades.</p>
        <?php else: ?>
            <!-- Loop through posts variable to disaply all availbe posts  -->

            <?php foreach ($posts as $post): ?>
                    <div class="om-content" style="border:1px solid #ccc; padding:10px; margin-bottom:10px;"> <p>On:
                        <small><?= htmlspecialchars($post['created']) ?></small>
                        <?= htmlspecialchars($post['username']) ?>
                        wrote:</p>
                    <p class="blog-title">
                        <b><?= nl2br(htmlspecialchars($post['title'])) ?></b>
                    </p>
                    <!-- link to choosen post and send postId in url for extraction in single_psot.php -->

                    <a href="single_post.php?postId=<?= urlencode($post['id']) ?>" class="btn-y">Read more</a>
                    <br>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
    <!-- include news for keeping user updated  -->
    <aside
        class="back-support"><?php include('../../app/includes/nyheter.php'); ?>
    </aside>
</div>
<!-- include footer  -->
<?php include('../../app/includes/footer.php') ?>

