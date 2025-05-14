<?php
include('./app/includes/header.php');
require_once 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$currentUser = $_SESSION['user'];
$userId = $currentUser['id'];
$username = htmlspecialchars($currentUser['username']);
$post = null;
$formSubmitted = false;


// Check if we're editing
if (isset($_GET['postId'])) {
    $postId = intval($_GET['postId']);
    $post = get_single_post($postId);

    // Check if the user owns this post
    if (!$post || $post['userId'] != $userId) {
        echo "<p>❌ You don't have permission to edit this post.</p>";
        exit();
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $userId = $_SESSION['user']['id'];

    $filename = null;
    if (!empty($_FILES["image"]["name"])) {
        $filename = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/$filename");
    }

    if (isset($_POST['postId'])) {
        // Editing
        $postId = intval($_POST['postId']);
        edit_post($postId, $title, $content, $userId);
        if ($filename) {
            insert_image($filename, $content, $postId);
        }
        echo "✅ Post updated!";
    } else {
        // Creating new post
        $postId = insert_post($title, $content, $userId);
        if ($filename) {
            insert_image($filename, $content, $postId);
        }
        echo "✅ Post uploaded!";
    }

    // Set flag after form submission
    $formSubmitted = true;

    // Reload for fresh data
    // $post = get_single_post($postId);
}
?>

<main>

    <div class="om-content">
        <h1 class="blue-font"><?= $post ? "Edit Your Post" : "Upload Your Content" ?>
            <?php echo $postId; ?>

        </h1>
    </div>

    <form class="om-content" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="postId" value="<?= $post ? $post['id'] : '' ?>">

        <div class="row-form blue-font">
            User:
            <strong><?= $username ?></strong><br>
        </div>
        <div class="row-form blue-font">
            Title:
            <input name="title" value="<?= $post ? htmlspecialchars($post['title']) : '' ?>" required><br>
        </div>
        <div class="row-form blue-font">
            Content:
            <textarea name="content" required><?= $post ? htmlspecialchars($post['content']) : '' ?></textarea><br>
        </div>
        <div class="row-form blue-font">
            Image:
            <input class="btn-y" type="file" name="image"><br>
        </div>
        <button class="btn-g" type="submit"><?= $post ? "Update Post" : "Upload Post" ?></button>
    </form>

</main>
<?php
include('./app/includes/footer.php'); ?>

<!-- Include the redirect script -->
<script src="./redirect.js"></script>
<script>
    <?php if ($formSubmitted): ?>
                redirectToContentPage();
        <?php endif; ?>
    </script>

