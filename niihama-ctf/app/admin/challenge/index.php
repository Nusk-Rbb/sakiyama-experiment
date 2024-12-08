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
                <li><a href="/admin/challenge">問題用ユーザー管理</a></li>
            </ul>
        </nav>
    </header>

    <div class="main">
        <h2>問題用ユーザー管理ページ</h2>
        <form action="index.php" method="POST">
            ユーザー名
            <input type="text" name="username" size="10">
            <input type="submit" name="search_ch" value="検索">
        </form>
        <table>
            <tr>
                <th>問題1</th>
            </tr>
            <tr>
                <th>ユーザー名</th>
                <th>パスワード</th>
            </tr>
            <?php
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $pdo = db_connect();

                    if ($_POST['username'] !== "") {
                        $username = $_POST['username'];
                        $sql = "SELECT * FROM user_ch1 WHERE username = :username";
                        $ch1_users = fetchAll($pdo, $sql, ["username" => $username]);
                    } else {
                        $sql = "SELECT * FROM user_ch1";
                        $ch1_users = fetchAll($pdo, $sql);
                    }


                    if (count($ch1_users) > 0) {
                        foreach ($ch1_users as $ch1) {
                            echo '<tr><td>' . $ch1['username'] . '</td><td>' . $ch1['password'] . '</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="2">一致するユーザーが見つかりません</td></tr>';
                    }
                } catch (PDOException $e) {
                    echo 'DB接続エラー: ' . $e->getMessage();
                }
            }
            ?>
            <br>
        </table>

        <table>
            <tr>
                <th>問題2</th>
            </tr>
            <tr>
                <th>ユーザー名</th>
                <th>パスワード</th>
            </tr>
            <?php
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $pdo = db_connect();

                    if ($_POST['username'] !== "") {
                        $username = $_POST['username'];
                        $sql = "SELECT * FROM user_ch2 WHERE username = :username";
                        $ch2_users = fetchAll($pdo, $sql, ["username" => $username]);
                    } else {
                        $sql = "SELECT * FROM user_ch2";
                        $ch2_users = fetchAll($pdo, $sql);
                    }


                    if (count($ch2_users) > 0) {
                        foreach ($ch2_users as $ch2) {
                            echo '<tr><td>' . $ch2['username'] . '</td><td>' . $ch2['password'] . '</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="2">一致するユーザーが見つかりません</td></tr>';
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