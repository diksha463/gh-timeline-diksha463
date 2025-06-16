<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);

    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Insert user data and set email_verified as false
        $sql = "INSERT INTO users (name, email, email_verified) VALUES (?, ?, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $email);

        if ($stmt->
