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
                <li><a href="insert.php"></a>登録</a></li>
                <li><a href="update.php">変更</a></li>
                <li><a href="delete.php">削除</a></li>
            </ul>
        </nav>
    </header>

    <div class="main">
        <h2>ユーザー削除ページ</h2>
        <form action="delete.php" method="POST">
            <select name="flag">
            <option value="---">削除するフラグ</option>
            <?php
                try {
                    $pdo = db_connect();
                    $sql = "SELECT * FROM flags";
                    $flags = fetchAll($pdo, $sql);
                    foreach ($flags as $flag) {
                        echo '<option value="' . $flag['flag'] . '">' . $flag['flag'] . '</option>';
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
        $flag = $_POST['flag'];
        try {
            $pdo = db_connect();
            $sql = "SELECT flag_id FROM flags WHERE flag = :flag";
            $flag_id = fetch($pdo, $sql, ["flag" => $flag]);
            if (!$flag) {
                echo "フラグが見つかりません";
                exit;
            }
            $flag_id = $flag_id['flag_id'];
            $delete = deleteStatement($pdo, "solves", "flag_id = $flag_id");
            if(!$delete){
                echo "削除に失敗しました";
                exit;
            }
            $delete = deleteStatement($pdo, "flags", "flag_id = $flag_id");
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