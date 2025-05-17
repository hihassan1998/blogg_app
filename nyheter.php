<?php
// include('./app/includes/header.php');
// include('./app/includes/content.php') ;

require_once('db.php');
$data = nyheter();
$users = $data['users'];
$posts = $data['posts'];
?>
<h1 class="yellow-font"> <b>  Keep updated! </b></h1>
<h3 class="">Newly added</h3>
<?php foreach ($posts as $post): ?>
    <article>
        <ul class="ullist">
            <a href="content.php?userId=<?= urlencode($user['id']) ?>">
                    <?= htmlspecialchars($post['title']) ?>
                </a>
        </ul>
</article>
<?php endforeach; ?>

<h3>New Users</h3>
<article>
    <ul>
        <?php foreach ($users as $user): ?>
            <li class="ullist">
                <a href="content.php?userId=<?= urlencode($user['id']) ?>">
                    <?= htmlspecialchars($user['username']) ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </article>
