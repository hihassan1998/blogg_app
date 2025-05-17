<?php
// this file renders the iamges from the uploads directory based on the iamge names stored in the iamges table in database
require_once('db.php');

function render_images_for_post($postId)
{
    echo "<!-- Trying to render images for post ID: $postId -->";

    $images = get_images($postId);
    if ($images && count($images) > 0) {
        echo "<!-- Found " . count($images) . " image(s) -->";
        foreach ($images as $image) {
            echo '<img class="centered" src="./uploads/' . htmlspecialchars($image['filename']) . '" alt="' .
                htmlspecialchars($image['description']) . '" style="max-width: 250px; margin-top: 10px;">';
        }
    } else {
        echo "<!-- No images found for post ID $postId -->";
    }
}

?>

