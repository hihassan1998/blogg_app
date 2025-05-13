<?php
include('./app/includes/header.php');
require_once 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $userId = $_SESSION['user']['id'];

    // Save file
    $filename = basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/$filename");

    // Insert post and image via db.php
    $postId = insert_post($title, $desc, $userId);
    insert_image($filename, $desc, $postId);

    echo "✅ Post uploaded!";
}
?>

<main>

    <div class="om-content">
        <h1 class="blue-font">Upload your content</h1>
    </div>

    <form class="om-content" method="POST" enctype="multipart/form-data">
        <div class="row-form blue-font">
            User ID: <input name="userId" required><br>
        </div>
        <div class="row-form blue-font">
            Title: <input name="title" required><br>
        </div>
        <div class="row-form blue-font">
            Content: <textarea name="content" required></textarea><br>
        </div>
        <div class="row-form blue-font">
            Image: <input class="btn-y" type="file" name="image"><br>
        </div>
        <button class="btn-g" type="submit">Upload Post</button>
    </form>

</main>
<?php
include('./app/includes/footer.php'); ?>