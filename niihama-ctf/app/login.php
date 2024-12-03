<?php
session_start();
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Database connection (PostgreSQL)
    try {
        $pdo = new PDO("pgsql:host=postgres;dbname=www", "apache", "passworda");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login successful (set session variables, redirect, etc.)
            $_SESSION['username'] = $username;
            $_SESSION['message'] = "ログインに成功しました。";
            header('Location: /');
            exit;
        } else {
            $_SESSION['error_message'] = 'ログインに失敗しました。';
            header('Location: /');
            exit;
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database Error: " . $e->getMessage() . "');</script>"; // Display error message Database Error;
    }
}
?>