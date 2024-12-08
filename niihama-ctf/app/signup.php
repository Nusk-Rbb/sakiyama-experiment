<?php
include("db/db_manage.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (retrieve form data as in previous examples)
    $username = $_POST['new_username'];
    $password = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if($password !== $confirmPassword) {
        echo 'パスワードが一致しません。';
    }

    try {
        $pdo = db_connect();
        
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
                $_SESSION['logged_in'] = true;
                header('Location: /');
            } else {
                echo 'ユーザー登録に失敗しました。';
            }
            exit;
        }

    } catch(PDOException $e) {
        echo "Database Error: " . $e->getMessage(); // Handle database errors
    }
}
?>