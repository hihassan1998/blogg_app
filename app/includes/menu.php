<!-- display information realted as a clickable menu for all posts available  -->

<?php if (isset($posts) && is_array($posts)): ?>
    <div class="post-list">
        <h3>All TItles</h3>
        <ul class="">
            <?php foreach ($posts as $p): ?>
                <li>
                    <a href="single_post.php?postId=<?= urlencode($p['id']) ?>">
                        <?= htmlspecialchars($p['title']) ?>
                    </a>
                </li>
                <br>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else: ?>
    <p>❌ No data availbe to display.</p>
<?php endif; ?>