<?php
require 'db.php';

$feedbackMessage = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $user = get_user($username); // Fetch user details from database

        if ($user) {
            // If user exists, verify the password
            if (password_verify($password, $user['password'])) {
                // Password is correct
                $feedbackMessage = "✅ Login successful!";
                // Start session and store user details in session if needed
                session_start();
                $_SESSION['user'] = $user; // Store user data in session

                // Redirect to dashboard or user home page (e.g. index.php)
                header("Location: dashboard.php"); // Adjust this to your desired page
                exit();
            } else {
                $feedbackMessage = "❌ Invalid username or password.";
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
        <div class="om-content"
            style="color: <?= strpos($feedbackMessage, '✅') !== false ? 'green' : 'red' ?>; margin-bottom: 10px;">
            <?= htmlspecialchars($feedbackMessage) ?>
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
            <button class="btn-g" type="submit">Login</button>
        </form>
    </div>
</main>