<!-- display information realted to a spedific post in single_post.php  -->

<?php if (isset($post)): ?>
        <div class="post-info" style="padding: 15px; border: 1px solid #ccc;"> <h3>
            <b>

                Blog Info
            </b>
        </h3>
        <p>
            <strong>Titel:</strong>
            <?= htmlspecialchars($post['title']) ?>
        </p>
        <p>
            <strong>Bloger:</strong>
            <?= htmlspecialchars($post['username']) ?>
        </p>
        <p>
            <strong>Written on:</strong>
            <?= htmlspecialchars($post['created']) ?>
        </p>
    </div>

    <!-- display message for user if unsuccessful  -->
<?php else: ?>
    <p>❌ No data availbe to display.</p>
<?php endif; ?>

