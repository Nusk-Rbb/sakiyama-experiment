<?php
include("db/db_manage.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (retrieve form data as in previous examples)
    $username = $_POST['new_username'];
    $password = $_POST['new_password'];

    try {
        $pdo = db_connect('postgres', 'www', 'apache', 'passworda');
        
        $sql = "SELECT * FROM users WHERE username = :username";
        $user = fetch($pdo, $sql, ["username"=> $username]);
        // Check if the username already exists
        if ($user) {
            echo '既にユーザー名が使われています。';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $table = 'users';
            $data = ['username' => $username, 'password' => $hashedPassword];
            insert($pdo, $table, $data);

            $sql = "SELECT * FROM users WHERE username = :username";
            $user = fetch($pdo, $sql, ["username"=> $username]);
            if($user) {
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SERVER['PHP_AUTH_USER'] = $user['username'];
                $_SERVER['PHP_AUTH_PW'] = $user['password'];
                header('Location: /dashboard.php');
            } else {
                $_SESSION['error_message'] = 'ユーザーIDの取得に失敗しました。';
                header('Location: /');
                exit;
            }
            exit;
        }

    } catch(PDOException $e) {
        echo "Database Error: " . $e->getMessage(); // Handle database errors
    }
}
?>