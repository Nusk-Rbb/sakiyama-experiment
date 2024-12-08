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
        <form action="update.php" method="POST">
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

<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $column = $_POST['column'];
    $value = $_POST['value'];
    echo $username . "<br>";
    echo $column . "<br>";
    echo $value . "<br>";
    try {
        $pdo = db_connect();

        $sql = "SELECT user_id FROM users WHERE username = :username";
        $user_id = fetch($pdo, $sql, ["username" => $username]);
        if (!$user_id) {
            echo "ユーザーが見つかりません";
            exit;
        }
        $user_id = $user_id['user_id'];

        if($column === "password"){
            $updateData = ["password" => password_hash($value, PASSWORD_DEFAULT)];
        } else {
            $updateData = ["username" => $value];
        }
        $update = update($pdo, "users", $updateData, "user_id = $user_id");
        if($update){
            echo "更新に成功しました";
        } else {
            echo "更新に失敗しました";
        }
        exit;
    } catch (PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
}
?>