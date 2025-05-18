<?php
session_start();
require '../../src/db.php';

$loggedInUser = $_SESSION['user'] ?? null;
$isOwner = isset($loggedInUser);
// Handle deletion

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletePostId']) && $isOwner) {
    $deletePostId = intval($_POST['deletePostId']);
    $post = get_single_post($deletePostId);
    if ($post && $post['userId'] === $loggedInUser['id']) {
        delete_post($deletePostId);
    }
}

header("Location: content.php");
exit();
