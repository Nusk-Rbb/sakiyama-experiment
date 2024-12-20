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
                <li><a href="insert.php"></a>登録</a></li>
                <li><a href="update.php">変更</a></li>
                <li><a href="delete.php">削除</a></li>
            </ul>
        </nav>
    </header>

    <div class="main">
        <h2>ユーザー削除ページ</h2>
        <form action="delete.php" method="POST">
            <select name="username">
            <option value="---">削除するユーザー</option>
            <?php
                try {
                    $pdo = db_connect();
                    $sql = "SELECT username FROM users";
                    $users = fetchAll($pdo, $sql);
                    foreach ($users as $user) {
                        if($user['username'] === "admin"){
                            continue;
                        }
                        echo '<option value="' . $user['username'] . '">' . $user['username'] . '</option>';
                    }
                } catch (PDOException $e) {
                    echo 'DB接続エラー: ' . $e->getMessage();
                }
            ?>
            </select>
            <input type="submit" name="delete" value="削除">
        </form>
    </div>
</body>

</html>
<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $username = $_POST['username'];
        try {
            $pdo = db_connect();
            $sql = "SELECT user_id FROM users WHERE username = :username";
            $user_id = fetch($pdo, $sql, ["username" => $username]);
            if (!$user_id) {
                echo "ユーザーが見つかりません";
                exit;
            }
            $user_id = $user_id['user_id'];
            $delete = deleteStatement($pdo, "scores", "user_id = $user_id");
            if(!$delete){
                echo "削除に失敗しました";
                exit;
            }
            $delete = deleteStatement($pdo, "solves", "user_id = $user_id");
            if(!$delete){
                echo "削除に失敗しました";
                exit;
            }
            $delete = deleteStatement($pdo, "users", "user_id = $user_id");
            if(!$delete){
                echo "削除に失敗しました";
                exit;
            }
            echo "削除に成功しました";
        } catch (PDOException $e) {
            echo 'DB接続エラー: ' . $e->getMessage();
        }
    }
?>