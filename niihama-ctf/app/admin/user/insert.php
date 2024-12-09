<?php
    include("../../db/db_manage.php");
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Niihama CTF</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <img src="/img/chara.png">
        <div class="container">
            <h1>Niihama CTF</h1>
            <p>Welcome to Niihama CTF!!</p>
        </div>
        <nav>
            <ul>
                <li><a href="/admin/">Admin Home</a></li>
                <li><a href="/admin/user">ユーザー管理</a></li>
                <li><a href="insert.php">登録</a></li>
                <li><a href="update.php">変更</a></li>
                <li><a href="delete.php">削除</a></li>
            </ul>
        </nav>
    </header>

    <div class="main">
        <h2>ユーザー登録ページ</h2>
        <form action="insert.php" method="POST">
            ユーザー名
            <input type="text" name="username" size="10" required>
            パスワード
            <input type="password" name="password" size="10" required>
            <input type="submit" name="insert" value="登録">
        </form>
    </div>
</body>

</html>
<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $pdo = db_connect();

        $sql = "SELECT * FROM users WHERE username = :username";
        $user = fetch($pdo, $sql, ["username" => $username]);
        // Check if the username already exists
        if ($user) {
            echo '既にユーザー名が使われています。';
            exit;
        }
        $insert = insert($pdo, "users", ["username" => $username, "password" => password_hash($password, PASSWORD_DEFAULT)]);
        if($insert){
            echo "登録に成功しました";
        } else {
            echo "登録に失敗しました";
        }
    } catch (PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
}
?>