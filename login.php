<?php
require 'db.php';

$feedbackMessage = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $user = get_user($username);

        if (!empty($user)) {
            $user = $user[0];
            $userId = $user['id'];

            $passwordData = get_password($userId);

            if (!empty($passwordData)) {
                $storedHashedPassword = $passwordData[0]['password'];

                if (password_verify($password, $storedHashedPassword)) {
                    // Successful login
                    session_start();
                    $_SESSION['user'] = $user;

                    header("Location: content.php");
                    exit();
                } else {
                    $feedbackMessage = "❌ Invalid username or password.";
                }
            } else {
                $feedbackMessage = "❌ Unable to retrieve password.";
            }
        } else {
            $feedbackMessage = "❌ Invalid username or password.";
        }
    } else {
        $feedbackMessage = "❗ Both fields are required.";
    }
}
?>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<?php include('./app/includes/header.php') ?>

<main class="">
    <?php if (!empty($feedbackMessage)): ?>
        <div
            style="color: <?= strpos($feedbackMessage, '✅') !== false ? 'green' : 'red' ?>; margin-bottom: 10px;"><?= htmlspecialchars($feedbackMessage) ?>
        </div>
    <?php endif; ?>
    <div class="om-content">
        <form method="post">
            <div class="row-form yellow-font">
                Username: <input name="username" required><br>
            </div>
            <div class="row-form yellow-font">
                Password: <input type="password" name="password" required><br>
            </div>
            <button class="btn-y" type="submit">Login</button>
            <br>
            <br>
            <a class="btn-g" href="./register.php">Register as a blogger</a>
        </form>
    </div>
</main>

<?php include('./app/includes/footer.php') ?>
