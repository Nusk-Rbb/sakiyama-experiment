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
        <h2>フラグ情報変更ページ</h2>
        <form action="update.php" method="POST">
            <select name="old_flag">
            <option value="---">変更するフラグ</option>
            <?php
                try {
                    $pdo = db_connect();

                    $sql = "SELECT * FROM flags";
                    $flags = fetchAll($pdo, $sql);

                    if (count($flags) > 0) {
                        foreach ($flags as $flag) {
                            echo '<option value="' . $flag['flag'] . '">' . $flag['flag'] . '</option>';
                        }
                    } else {
                        echo '<tr><td colspan="2">一致するユーザーが見つかりません</td></tr>';
                    }
                } catch (PDOException $e) {
                    echo 'DB接続エラー: ' . $e->getMessage();
                }
            ?>
            </select>
            <input type="text" name="new_flag" placeholder="新しい値を入力">
            <input type="submit" name="update" value="更新">
        </form>
    </div>
</body>

</html>

<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_flag = $_POST['old_flag'];
    $new_flag = $_POST['new_flag'];
    try {
        $pdo = db_connect();

        $sql = "SELECT flag_id FROM flags WHERE flag = :flag";
        $flag_id = fetch($pdo, $sql, ["flag" => $old_flag]);
        if (!$flag_id) {
            echo "ユーザーが見つかりません";
            exit;
        }
        $flag_id = $flag_id['flag_id'];

        $updateData = ["flag" => $new_flag];
        $update = update($pdo, "flags", $updateData, "flag_id = $flag_id");
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