<?php
session_start();
require_once 'functions.php';

$step = isset($_SESSION['step']) ? $_SESSION['step'] : 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $_SESSION['email'] = $_POST['email'];
        $code = generateVerificationCode();
        echo "<p style='color:red;'>DEBUG CODE (for testing): <strong>$code</strong></p>";

        $_SESSION['verification_code'] = $code;
        sendVerificationEmail($_SESSION['email'], $code);
        $_SESSION['step'] = 2;
        $step = 2;
    } elseif (isset($_POST['verification_code'])) {
        if ($_POST['verification_code'] == $_SESSION['verification_code']) {
            registerEmail($_SESSION['email']);
            echo "<p>Email verified and registered successfully!</p>";
            session_destroy();
        } else {
            echo "<p>Invalid verification code.</p>";
        }
    }
}
?>

<h2>Register Email</h2>
<form method="post">
    <input type="email" name="email" required>
    <button id="submit-email">Submit</button>
</form>

<h2>Verify Code</h2>
<form method="post">
    <input type="text" name="verification_code" maxlength="6" required>
    <button id="submit-verification">Verify</button>
</form>

