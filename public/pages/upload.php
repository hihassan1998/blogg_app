<?php
// start session
session_start();

require_once '../../src/db.php';


// Check if logged, redirect otherwise
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once('render_image.php');

include('../../app/includes/header.php');

// set variables
$currentUser = $_SESSION['user'];
$userId = $currentUser['id'];
$username = htmlspecialchars($currentUser['username']);
$post = null;
$formSubmitted = false;
$message = ''; // Variable to hold the message


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
            delete_image_file($postId);
            insert_image($filename, $content, $postId);
        }
        $message = "Post successfully uploaded! ✅";
    } else {
        // Creating new post
        $postId = insert_post($title, $content, $userId);
        if ($filename) {
            insert_image($filename, $content, $postId);
        }
        $message = "Post successfully uploaded! ✅";
    }

    // Set flag after form submission
    $formSubmitted = true;

    // Reload for fresh data
    $post = get_single_post($postId);
}
?>
<!-- Include the redirect script -->
<script src="../js/redirect.js"></script>
<script>
    <?php if ($formSubmitted): ?>
                redirectToContentPage();
    <?php endif; ?>
    </script>
        
        
<main>
    

    <div class="om-content">
        <h1 class="blue-font"><?= $post ? "Edit Your Post (ID: " . htmlspecialchars($post['id']) . ")" : "Upload Your Content" ?>
            <?#php echo $postId; ?>
        </h1>
    </div>

    <?php if ($message): ?>
        <div class="om-content">
            <p><?= $message ?></p>
        </div>
    <?php endif; ?>


    <form
        class="om-content" method="POST" enctype="multipart/form-data">
        <?php if ($post): ?>
                            <input
                            type="hidden" name="postId" value="<?= $post['id'] ?>">
        <?php endif; ?>
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
<!-- display image that is already set  -->

        <div
            class="row-form blue-font">
            <?php if ($post): ?>
            <div class="row-form blue-font">
                <p>Current image:</p>

                <?php
                render_images_for_post($post['id']);
                ?>
                <?php endif; ?>
            </div>
        </div>


        <button class="btn-g" type="submit"><?= $post ? "Update Post" : "Upload Post" ?></button>
    </form>


</main>
<?php
// incude footer
include('../../app/includes/footer.php'); ?>

