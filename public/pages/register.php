<?php
session_start();

require '../../src/db.php';


$feedbackMessage = '';

// handel form post request and save encrypted apssword indb
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        if (strlen($password) < 6) {
            $feedbackMessage = "❗ Password must be at least 6 characters long.";
        } else {
            $existingUser = get_user($username);

            if (!empty($existingUser)) {
                $feedbackMessage = "❌ User already registered.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                add_user($username, $hashed_password);
                header("Location: register.php?success=1");
                exit();
            }
        }
    } else {
        $feedbackMessage = "❗ Both fields are required.";
    }
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $feedbackMessage = "✅ User registered successfully!";
}
include('../../app/includes/header.php');
?>

<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>

<main class="back-support">
    <div
        class="container">
        <?php if (!empty($feedbackMessage)): ?>
            <div
                class="om-content" style="color: <?= strpos($feedbackMessage, '✅') !== false ? 'green' : 'red' ?>; margin-bottom: 10px;"><?= htmlspecialchars($feedbackMessage) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="row-form yellow-font">
                Username:
                <input name="username" required><br>
            </div>
            <div class="row-form yellow-font">
                Password:
                <input type="password" name="password" required><br>
            </div>
            <button class="btn-y" type="submit">Register</button>
        </form>
    </div>
</main>

<?php include('../../app/includes/footer.php') ?>

