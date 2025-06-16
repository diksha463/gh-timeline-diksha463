<?php

function generateVerificationCode() {
    return rand(100000, 999999);
}

function registerEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    if (!file_exists($file)) {
        file_put_contents($file, '');
    }

    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!in_array($email, $emails)) {
        file_put_contents($file, $email . PHP_EOL, FILE_APPEND);
    }
}

function unsubscribeEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    if (!file_exists($file)) return;

    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $updatedEmails = array_filter($emails, fn($e) => trim($e) !== trim($email));
    file_put_contents($file, implode(PHP_EOL, $updatedEmails) . PHP_EOL);
}

function sendVerificationEmail($email, $code, $isUnsubscribe = false) {
    $subject = $isUnsubscribe ? "Confirm Unsubscription" : "Your Verification Code";
    $message = $isUnsubscribe ?
        "<p>To confirm unsubscription, use this code: <strong>$code</strong></p>" :
        "<p>Your verification code is: <strong>$code</strong></p>";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: no-reply@example.com\r\n";

    mail($email, $subject, $message, $headers);
}

function fetchGitHubTimeline() {
    // Simulated GitHub timeline data
    return [
        ['type' => 'PushEvent', 'actor' => ['login' => 'devuser1']],
        ['type' => 'PullRequestEvent', 'actor' => ['login' => 'devuser2']],
        ['type' => 'IssueCommentEvent', 'actor' => ['login' => 'devuser3']]
    ];
}

function formatGitHubData($data) {
    $html = "<h2>GitHub Timeline Updates</h2><table border='1'><tr><th>Event</th><th>User</th></tr>";
    foreach ($data as $event) {
        $eventType = htmlspecialchars($event['type'] ?? 'Unknown');
        $username = htmlspecialchars($event['actor']['login'] ?? 'Anonymous');
        $html .= "<tr><td>$eventType</td><td>$username</td></tr>";
    }
    $html .= "</table>";
    return $html;
}

function sendGitHubUpdatesToSubscribers() {
    $file = __DIR__ . '/registered_emails.txt';
    if (!file_exists($file)) return;

    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!$emails) return;

    $data = fetchGitHubTimeline();
    $html = formatGitHubData($data);
    $html .= "<p><a href='http://localhost/email-system/src/unsubscribe.php' id='unsubscribe-button'>Unsubscribe</a></p>";

    $subject = "Latest GitHub Updates";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: no-reply@example.com\r\n";

    foreach ($emails as $email) {
        mail($email, $subject, $html, $headers);
    }
}
?>
