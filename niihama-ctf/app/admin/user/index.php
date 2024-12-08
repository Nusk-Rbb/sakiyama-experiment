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
        <h2>管理者ページ</h2>
        <form action="index.php" method="POST">
            ユーザー名
            <input type="text" name="username" size="10">
            <input type="submit" name="search" value="検索">
        </form>
        <table>
            <tr>
                <th>ユーザーID</th>
                <th>ユーザー名</th>
                <th>パスワード</th>
            </tr>
            <?php
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $pdo = db_connect();

                    if ($_POST['username'] !== "") {
                        $username = $_POST['username'];
                        $sql = "SELECT * FROM users WHERE username = :username";
                        $users = fetchAll($pdo, $sql, ["username" => $username]);
                    } else {
                        $sql = "SELECT * FROM users ORDER BY user_id ASC";
                        $users = fetchAll($pdo, $sql);
                    }


                    if (count($users) > 0) {
                        foreach ($users as $user) {
                            echo '<tr><td>' . $user['user_id'] . '</td><td>' . $user['username'] . '</td><td>' . $user['password'] . '</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">一致するユーザーが見つかりません</td></tr>';
                    }
                } catch (PDOException $e) {
                    echo 'DB接続エラー: ' . $e->getMessage();
                }
            }
            ?>
            <br>
        </table>
    </div>
</body>

</html>