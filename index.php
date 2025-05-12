<?php
require_once('db.php');

$users = get_users();
$posts = get_posts();
?>


<head>
    <meta charset="UTF-8">
    <title>Användarlista</title>
</head>

<?php include('./app/includes/header.php') ?>
<main class=" back-support">

    <h1 class="yellow-title special-heading">Välkommen till Blogg Appen!</h1>
    <hr>
    
    <div class="yellow-font back-support">
        <h1 class="green-font special-heading">Get creative, inovative or simply write your heart out !</h1>
        <p>Detta är en enkel bloggapplikation där du kan logga in och se användarnas inlägg.</p>
        <br>
        <a class="btn-y2" href="login.php">Logga in</a>
         <br>
    <br>
    <hr>
    </div>
    
    
   
</main>

<?php include('./app/includes/footer.php') ?>
