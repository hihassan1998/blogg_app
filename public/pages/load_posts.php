<?php
session_start();

require '../../src/db.php';

$loggedInUser = $_SESSION['user'] ?? null;
$viewingUser = null;

if (isset($_GET['userId'])) {
    $viewingUserId = intval($_GET['userId']);
    $viewingUser = get_user_by_id($viewingUserId);
    if (!$viewingUser) {
        echo "<p>User not found.</p>";
        exit();
    }
} elseif ($loggedInUser) {
    $viewingUser = $loggedInUser;
    $viewingUserId = $loggedInUser['id'];
} else {
    header("Location: login.php");
    exit();
}

$isOwner = $loggedInUser && ($loggedInUser['id'] === $viewingUserId);
$posts = get_user_posts($viewingUserId);

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletePostId']) && $isOwner) {
    $deletePostId = intval($_POST['deletePostId']);
    $post = get_single_post($deletePostId);
    if ($post && $post['userId'] === $viewingUserId) {
        delete_post($deletePostId);
        header("Location: content.php");
        exit();
    } else {
        echo "<p>❌ You don't have permission to delete this post.</p>";
    }
}
