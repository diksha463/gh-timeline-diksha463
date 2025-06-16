<?php
session_start();
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verification_code'])) {
    $inputCode = trim($_POST['verification_code']);

    if (
        isset($_SESSION['verification_code']) &&
        isset($_SESSION['pending_email']) &&
        $_SESSION['verification_code'] === $inputCode
    ) {
        $email = $_SESSION['pending_email'];

        // Register the verified email
        registerEmail($email);

        // Clear session
        unset($_SESSION['verification_code']);
        unset($_SESSION['pending_email']);

        echo "<p>Email verified and registered successfully: <strong>$email</strong></p>";
        echo '<a href="index.php">Go Back</a>';
    } else {
        echo "<p>Invalid verification code. Try again.</p>";
        echo '<a href="index.php">Go Back</a>';
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>
