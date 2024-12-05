<?php
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
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['password'] = $user['password'];

            // Get the user's score
            $stmt = $pdo->prepare("SELECT * FROM scores WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user['user_id']);
            $stmt->execute();
            $user_score = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the score was successfully retrieved
            if($user_score) {
                $_SESSION['score'] = $user_score['score'];
                $_SESSION['message'] = 'ログインに成功しました。';
            } else {
                $_SESSION['error_message'] = 'スコアの取得に失敗しました。';
                header('Location: /');
                exit;
            }

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