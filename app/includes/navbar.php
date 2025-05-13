<?php include('./app/config/config.php')?>
<nav class="navbar">
    <button class="hamburger-menu">&#9776;</button>



    <ul class="navbar-menu">
        <li>
            <a href="./index.php">
                <img class="logo" src="./public/img/logo/blog_icon.png" alt="Go to Home Page" style="width:75px;">
            </a>
        </li>
        <li><a href="./index.php">Hem</a></li>
        <li><a href="./register.php">Register User</a></li>
        <li><a href="./posts.php">Blogs</a></li>
        <li><a href="./upload.php">Upload Blog</a></li>
        
        <?php if (isset($_SESSION['user'])): ?>
            <li class="green-font">
                👤 <?= htmlspecialchars($_SESSION['user']['username']) ?> (ID: <?= $_SESSION['user']['id'] ?>)
            </li>
            <li><a class="btn-y" href="logout.php">Logga ut</a></li>
        <?php else: ?>
            <li><a class="btn-g" href="login.php">Logga in</a></li>
        <?php endif; ?>
        
        <li></li>
    </ul>

</nav>