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
                <li><a href="/admin/flag">フラグ管理</a></li>
                <li><a href="insert.php">登録</a></li>
                <li><a href="update.php">変更</a></li>
                <li><a href="delete.php">削除</a></li>
            </ul>
        </nav>
    </header>

    <div class="main">
        <h2>フラグ登録ページ</h2>
        <form action="insert.php" method="POST">
            <input type="text" name="flag" placeholder="フラグ名">
            <input type="submit" name="insert" value="登録" required>
        </form>
    </div>
</body>

</html>
<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flag = $_POST['flag'];
    try {
        $pdo = db_connect();

        $sql = "SELECT * FROM flags WHERE flag = :flag";
        $user = fetch($pdo, $sql, ["flag" => $flag]);
        // Check if the username already exists
        if ($user) {
            echo '既にフラグが登録されています。';
            exit;
        }

        $insert = insert($pdo, "flags", ["flag" => $flag]);
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