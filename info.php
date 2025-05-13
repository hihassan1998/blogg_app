<?php if (isset($post)): ?>
    <div class="post-info" style="padding: 15px; border: 1px solid #ccc;">
        <h3>Blog Info</h3>
        <p><strong>Titel:</strong> <?= htmlspecialchars($post['title']) ?></p>
        <p><strong>Blogs:</strong> <?= htmlspecialchars($post['username']) ?></p>
        <p><strong>Written on:</strong> <?= htmlspecialchars($post['created']) ?></p>
    </div>
<?php elseif (isset($posts) && is_array($posts)): ?>
    <div class="post-list" style="padding: 15px; border: 1px solid #ccc;">
        <h3>All bloggtitlar</h3>
        <ul>
            <?php foreach ($posts as $p): ?>
                <li>
                    <a href="single_post.php?postId=<?= urlencode($p['id']) ?>">
                        <?= htmlspecialchars($p['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else: ?>
    <p>❌ No data availbe to display.</p>
<?php endif; ?>
