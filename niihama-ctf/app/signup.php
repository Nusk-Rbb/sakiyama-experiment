<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (retrieve form data as in previous examples)
    $username = $_POST['new_username'];
    $password = $_POST['new_password'];

    try {
        $pdo = new PDO("pgsql:host=postgres;dbname=www", "apache", "passworda");  // PostgreSQL connection
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if username or email already exists (important!)
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch()) {
            echo '既にユーザー名が使われています。';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'サインアップに成功しました。';
                header('Location: /');
            } else {
                $_SESSION['error_message'] = 'サインアップに失敗しました。';
                header('Location: /');
            }
        }

    } catch(PDOException $e) {
        echo "Database Error: " . $e->getMessage(); // Handle database errors
    }
}
?>