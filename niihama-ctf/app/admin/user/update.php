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
        <h2>ユーザ情報変更ページ</h2>
        <form action="userController.php" method="PUT">
            <select name="username">
            <option value="---">変更するユーザー</option>
            <?php
                try {
                    $pdo = db_connect();

                    $sql = "SELECT * FROM users";
                    $users = fetchAll($pdo, $sql);

                    if (count($users) > 0) {
                        foreach ($users as $user) {
                            echo '<option value="' . $user['username'] . '">' . $user['username'] . '</option>';
                        }
                    } else {
                        echo '<tr><td colspan="3">一致するユーザーが見つかりません</td></tr>';
                    }
                } catch (PDOException $e) {
                    echo 'DB接続エラー: ' . $e->getMessage();
                }
            ?>
            </select>
            <select name="column">
            <option value="---">変更する項目</option>
            <option value="username">ユーザー名</option>
            <option value="password">パスワード</option>
            </select>
            <input type="text" name="value" placeholder="新しい値を入力">
            <input type="submit" name="update" value="更新">
        </form>
    </div>
</body>

</html>