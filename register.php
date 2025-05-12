<?php
require 'db.php';

$feedbackMessage = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $existingUser = get_user($username);

        if (!empty($existingUser)) {
            // Username already exists
            $feedbackMessage = "❌ User already registered.";
        } else {
            // Register new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            add_user($username, $hashed_password);

            // Redirect to avoid resubmission
            header("Location: register.php?success=1");
            exit();
        }
    } else {
        $feedbackMessage = "❗ Both fields are required.";
    }
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $feedbackMessage = "✅ User registered successfully!";
}
?>

<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<?php include('./app/includes/header.php') ?>

<main class="back-support">
    <div class="container">




        <?php if (!empty($feedbackMessage)): ?>
            <div class="om-content" style="color: <?= strpos($feedbackMessage, '✅') !== false ? 'green' : 'red' ?>; margin-bottom: 10px;">
                <?= htmlspecialchars($feedbackMessage) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="row-form yellow-font">
                Username: <input name="username" required><br>
            </div>
            <div class="row-form yellow-font">
                Password: <input type="password" name="password" required><br>
            </div>
            <button class="btn-y" type="submit">Register</button>
        </form>
    </div>
</main>

<?php include('./app/includes/footer.php') ?>
