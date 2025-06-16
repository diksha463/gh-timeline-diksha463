<?php
$filename = 'registered_emails.txt';

echo "<h2>Registered Emails</h2>";

if (file_exists($filename)) {
    $emails = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (count($emails) > 0) {
        echo "<ul>";
        foreach ($emails as $email) {
            echo "<li>" . htmlspecialchars($email) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No emails have been registered yet.</p>";
    }
} else {
    echo "<p>No registration file found.</p>";
}
?>
