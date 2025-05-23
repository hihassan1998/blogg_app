<?php
session_start();
require '../../src/db.php';

$feedbackMessage = '';

// HAndle forms post request and check for user inputs
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    // Display error message if user input missing
    if (empty($username)) {
        $feedbackMessage = "❗ User name not given.";
    } elseif (empty($password)) {
        $feedbackMessage = "❗ Password not given.";
    } else {
        $user = get_user($username);
        // Display feedbak to user based thier input text
        if (!empty($user)) {
            $user = $user[0];
            $userId = $user['id'];

            $passwordData = get_password($userId);

            if (!empty($passwordData)) {
                $storedHashedPassword = $passwordData[0]['password'];

                if (password_verify($password, $storedHashedPassword)) {
                    // Successful login
                    $_SESSION['user'] = $user;

                    header("Location: admin.php");
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
    }
}
// include header 
include('../../app/includes/header.php');
?>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<main>
    <!-- display message for user to direct user and update user with input feedback  -->

    <?php if (!empty($feedbackMessage)): ?><div
            style="color: <?= strpos($feedbackMessage, '✅') !== false ? 'green' : 'red' ?>; margin-bottom: 10px;"> <?= htmlspecialchars($feedbackMessage) ?>
        </div>
    <?php endif; ?>
    <div
        class="om-content">
        <!-- user login form Post request  -->

        <form method="post">
            <div class="row-form yellow-font">
                Username:
                <input name="username" required><br>
            </div>
            <div class="row-form yellow-font">
                Password:
                <input type="password" name="password" required><br>
            </div>
            <button class="btn-y" type="submit">Login</button>
            <br>
            <br>
            <a class="btn-g" href="./register.php">Register as a blogger</a>
        </form>
    </div>
</main>
<!-- include footer  -->
<?php include('../../app/includes/footer.php') ?>

