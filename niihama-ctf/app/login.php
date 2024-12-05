<?php
include("db/db_manage.php");
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Database connection (PostgreSQL)
    try {
        $pdo = db_connect('postgres', 'www', 'apache', 'passworda');

        $sql = "SELECT * FROM users WHERE username = :username";
        $user = fetch($pdo, $sql, ['username' => $username]);

        if ($user && password_verify($password, $user['password'])) {
            // Login successful (set session variables, redirect, etc.)
            session_start();
            $_SESSION['user_id'] = $user['user_id'];

            // Get the user's score
            $sql = "SELECT * FROM scores WHERE user_id = :user_id";
            $user_score = fetch($pdo, $sql, ['user_id' => $user['user_id']]);

            // Check if the score was successfully retrieved
            if($user_score) {
                $_SESSION['score'] = $user_score['score'];
                $_SESSION['message'] = 'ログインに成功しました。';
            } else {
                $_SESSION['error_message'] = 'スコアの取得に失敗しました。';
                header('Location: /');
                exit;
            }

            $_SESSION['logged_in'] = true;
            $_SERVER['PHP_AUTH_USER'] = $user['username'];
            $_SERVER['PHP_AUTH_PW'] = $user['password'];
            header('Location: /');

        } else {
            $_SESSION['error_message'] = 'ログインに失敗しました。';
            header('Location: /');
            exit;
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
    exit;
}
?>