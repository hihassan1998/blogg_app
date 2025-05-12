<?php
include('./app/includes/header.php');
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $userId = $_POST['userId']; // In real app, you'd use session

    // Save file
    $filename = basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/$filename");

    // Insert post
    global $connection;
    $sql = "INSERT INTO post (title, content, userId) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $title, $desc, $userId);
    mysqli_stmt_execute($stmt);
    $postId = mysqli_insert_id($connection);
    mysqli_stmt_close($stmt);

    // Insert image
    $sql = "INSERT INTO image (filename, description, postId) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $filename, $desc, $postId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "Post uploaded!";
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
            Description: <textarea name="desc" required></textarea><br>
        </div>
        <div class="row-form blue-font">
            Image: <input class="btn-y" type="file" name="image"><br>
        </div>
        <button class="btn-g" type="submit">Upload Post</button>
    </form>

</main>
<?php
include('./app/includes/footer.php'); ?>