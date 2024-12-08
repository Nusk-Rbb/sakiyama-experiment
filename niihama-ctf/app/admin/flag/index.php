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
                <li><a href="/admin/">管理者用ページ</a></li>
                <li><a href="/admin/flag">フラグ管理</a></li>
                <li><a href="insert.php">登録</a></li>
                <li><a href="update.php">変更</a></li>
                <li><a href="delete.php">削除</a></li>
            </ul>
        </nav>
    </header>

    <div class="main">
        <h2>管理者ページ</h2>
        <table>
            <tr>
                <th>フラグ゙ID</th>
                <th>フラグ</th>
            </tr>
            <?php
            try {
                $pdo = db_connect();
                $sql = "SELECT * FROM flags ORDER BY flag_id";
                $flags = fetchAll($pdo, $sql);

                if (count($flags) > 0) {
                    foreach ($flags as $flag) {
                        echo '<tr><td>' . $flag['flag_id'] . '</td><td>' . $flag['flag'] . '</td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">一致するフラグが見つかりません</td></tr>';
                }
            } catch (PDOException $e) {
                echo 'DB接続エラー: ' . $e->getMessage();
            }
            ?>
            <br>
        </table>
    </div>
</body>

</html>