<?php
// include('./app/includes/header.php');
// include('./app/includes/content.php') ;

require_once('../../src/db.php');

// get news as arrays
$data = nyheter();
// Set arrays to variables
$users = $data['users'];
$posts = $data['posts'];
?>
<h1 class="yellow-font">
    <b>
        Keep updated!
    </b>
</h1>
<!-- Loop through variable arrays to dispaly all posts as clickable anchor tags-->
<h3 class="">Newly added</h3>
<!-- display latest posts added  -->

<?php foreach ($posts as $post): ?>
    <article>
        <ul class="ullist">
            <a
                href="single_post.php?postId=<?= urlencode($post['id']) ?>"><?= htmlspecialchars($post['title']) ?>
            </a>
        </ul>
    </article>
<?php endforeach; ?>
<!--  Dispay users added -->
<h3>New Users</h3>
<article>
    <ul>
        <?php foreach ($users as $user): ?>
            <li class="ullist">
                <a
                    href="content.php?userId=<?= urlencode($user['id']) ?>"><?= htmlspecialchars($user['username']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</article>

