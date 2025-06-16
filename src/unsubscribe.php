<?php
session_start();
require_once 'functions.php';

// Determine the step
$step = isset($_SESSION['unsubscribe_step']) ? $_SESSION['unsubscribe_step'] : 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['unsubscribe_email'])) {
        $_SESSION['unsubscribe_email'] = $_POST['unsubscribe_email'];
        $code = generateVerificationCode();
        $_SESSION['unsubscribe_code'] = $code;

        sendVerificationEmail($_SESSION['unsubscribe_email'], $code, true); // true for unsubscribe mode
        $_SESSION['unsubscribe_step'] = 2;
        $step = 2;
    } elseif (isset($_POST['unsubscribe_verification_code'])) {
        if ($_POST['unsubscribe_verification_code'] == $_SESSION['unsubscribe_code']) {
            unsubscribeEmail($_SESSION['unsubscribe_email']);
            echo "<p style='color:green;'>✅ Email successfully unsubscribed.</p>";
            session_destroy();
            $step = 0;
        } else {
            echo "<p style='color:red;'>❌ Invalid code. Please try again.</p>";
        }
    }
}
?>

<h2>Unsubscribe from Emails</h2>

<?php if ($step === 1): ?>
    <form method="post">
        <label for="unsubscribe_email">Enter your email to unsubscribe:</label><br>
        <input type="email" name="unsubscribe_email" required>
        <button type="submit" id="submit-unsubscribe">Unsubscribe</button>
    </form>
<?php endif; ?>

<?php if ($step === 2): ?>
    <form method="post">
        <label for="unsubscribe_verification_code">Enter the verification code sent to your email:</label><br>
        <input type="text" name="unsubscribe_verification_code" maxlength="6" required>
        <button type="submit" id="verify-unsubscribe">Verify</button>
    </form>
<?php endif; ?>
