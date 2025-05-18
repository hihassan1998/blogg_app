<?php
// start session
session_start();

// use db.php for databse quesries
require_once('../../src/db.php');

// define users and posts
$users = get_users();
$posts = get_posts();
?>


<head>
    <meta charset="UTF-8">
    <title>Användarlista</title>
</head>
<?php
// include a header to the page
include('../../app/includes/header.php')
    ?>
<main class=" back-support">


    <div class="contactlayout">

        <div class="part">
            <h1 class="yellow-font">
                <b>Welcome to Blogster !
                </b>
            </h1>
        </div>
        <div class="part centered">
            <div>
                <img style="max-width: 250px;" src="../../public/img/logo/blog_icon.png" alt="">
            </div>
        </div>
    </div>
    <div class="yellow-font back-support centered">
        <h3 class="">Get creative, inovative or simply write your heart out !</h3>
        <p>This is a simple bloging application where you can register as a blogger, read, create, update or delte blogs.</p>
        <br>
        <a class="btn-y2" href="login.php">Log in</a>
        <br>
        <br>
        <hr>
    </div>


</main>

<?php // include a footer to the page
include('../../app/includes/footer.php') ?>

