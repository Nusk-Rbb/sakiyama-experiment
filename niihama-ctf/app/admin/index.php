<?php
    include("../db/db_manage.php");
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
                <li><a href="/">Home</a></li>
                <li><a href="/admin">管理者ページ</a></li>
                <li><a href="/admin/user.php">ユーザー管理</a></li>
            </ul>
        </nav>
    </header>

    <div class="main">
        <h2>管理者ページ</h2>
        <table class="scores">
            <tr>
                <th>ユーザーID</th>
                <th>スコア</th>
            </tr>
            <?php
                try {
                    $pdo = db_connect();
                    $sql = "SELECT * FROM scores ORDER BY score ASC";
                    $scores = fetchAll($pdo, $sql);
                    foreach ($scores as $score) {
                        echo '<tr><td>' . $score['user_id'] . '</td><td>' . $score['score'] . '</td></tr>';
                    }
                } catch (PDOException $e) {
                    echo 'DB接続エラー: ' . $e->getMessage();
                }
            ?>
            <br>
        </table>

        <table class="users">
            <tr>
                <th>ユーザーID</th>
                <th>ユーザー名</th>
                <th>パスワード</th>
            </tr>
            <?php
                try {
                    $pdo = db_connect();
                    $sql = "SELECT * FROM users ORDER BY user_id ASC";
                    $users = fetchAll($pdo, $sql);
                    foreach ($users as $user) {
                        echo '<tr><td>' . $user['user_id'] . '</td><td>' . $user['username'] . '</td><td>' . $user['password'] . '</td></tr>';
                    }
                } catch (PDOException $e) {
                    echo 'DB接続エラー: ' . $e->getMessage();
                }
            ?>
            <br>
        </table>

        <table class="flags">
            <tr>
                <th>フラグID</th>
                <th>フラグ</th>
            </tr>
            <?php
                try {
                    $pdo = db_connect();
                    $sql = "SELECT * FROM flags ORDER BY flag_id ASC";
                    $flags = fetchAll($pdo, $sql);
                    foreach ($flags as $flag) {
                        echo '<tr><td>' . $flag['flag_id'] . '</td><td>' . $flag['flag'] . '</td></tr>';
                    }
                } catch (PDOException $e) {
                    echo 'DB接続エラー: ' . $e->getMessage();
                }
            ?>
            <br>
        </table>
        
        <table class="challenge1">
            <tr>
                <th>ユーザー名</th>
                <th>パスワード</th>
            </tr>
            <?php
                try {
                    $pdo = db_connect();
                    $sql = "SELECT * FROM user_ch1";
                    $users = fetchAll($pdo, $sql);
                    foreach ($users as $user) {
                        echo '<tr><td>' . $user['username'] . '</td><td>' . $user['password'] . '</td></tr>';
                    }
                } catch (PDOException $e) {
                    echo 'DB接続エラー: ' . $e->getMessage();
                }
            ?>
            <br>
        </table>

        <table class="challenge2">
            <tr>
                <th>ユーザー名</th>
                <th>パスワード</th>
            </tr>
            <?php
                try {
                    $pdo = db_connect();
                    $sql = "SELECT * FROM user_ch2";
                    $users = fetchAll($pdo, $sql);
                    foreach ($users as $user) {
                        echo '<tr><td>' . $user['username'] . '</td><td>' . $user['password'] . '</td></tr>';
                    }
                } catch (PDOException $e) {
                    echo 'DB接続エラー: ' . $e->getMessage();
                }
            ?>
            <br>
        </table>

        <table>
            <tr>
                <th>ユーザーID</th>
                <th>フラグID</th>
                <th>正解済み</th>
            </tr>
            <?php
                try {
                    $pdo = db_connect();
                    $sql = "SELECT * FROM solves ORDER BY user_id ASC";
                    $solves = fetchAll($pdo, $sql);
                    foreach ($solves as $solve) {
                        if($solve['solved'] == 1) {
                            $solve['solved'] = '✅';
                        } else {
                            $solve['solved'] = '❌';
                        }
                        echo '<tr><td>' . $solve['user_id'] . '</td><td>' . $solve['flag_id'] . '</td><td>' . $solve['solved'] . '</td></tr>';
                    }
                } catch (PDOException $e) {
                    echo 'DB接続エラー: ' . $e->getMessage();
                }
            ?>
            <br>
        </table>
    </div>
    <script src="/js/script.js"></script>
</body>

</html>