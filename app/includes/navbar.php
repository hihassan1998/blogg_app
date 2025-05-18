<?#php include('../../app/config/config.php')?>
<nav class="navbar">
    <button class="hamburger-menu">&#9776;</button>

    <ul class="navbar-menu">
        <li>
            <a href="./index.php">
                <img class="logo" src="../../public/img/logo/blog_icon.png" alt="Go to Home Page" style="width:75px;">
            </a>
        </li>
        <li><a href="./index.php">Home</a></li>
        <li><a href="./posts.php">Blogs</a></li>
        <li><a href="./upload.php">Upload Blog</a></li>
        
        <?php if (isset($_SESSION['user'])): ?>
        <li><a href="./content.php">My Posts</a></li>

            <li class="green-font">
        <a href="./admin.php" style="color:inherit; text-decoration:none;">
            👤 <?= htmlspecialchars($_SESSION['user']['username']) ?> (ID: <?= $_SESSION['user']['id'] ?>)
        </a>
    </li>
            <li><a class="btn-y" href="logout.php">Log out</a></li>
        <?php else: ?>
            <li><a class="btn-g" href="login.php">Log in</a></li>
             <a class="btn-y" href="./register.php">Register as a blogger</a>
        <?php endif; ?>
        
        <li></li>
    </ul>

</nav>