<!DOCTYPE html">
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品注文完了</title>
</head>

<body>

<?php
    include('./common.php');
    include('./authcheck.php');			// ユーザ認証
?>

<h2>商品注文完了</h2>

<form action="login.php" method="POST">
<input type="hidden" name="uname" value="<?php echo $uname; ?>">
<input type="hidden" name="pass" value="<?php echo $pass; ?>">
<input type="submit" value="戻る">
</form>

<?php
    $con = dbstart( );
    $sql = "SELECT MAX(id) FROM chumon";	// id の自動作成
    $R   = pg_query($con, $sql);
    $dat = pg_fetch_array($R, 0);
    $id  = ($dat[0] == 0) ? 1 : $dat[0] + 1;

    $sql = "SELECT uid FROM kokyaku WHERE uname='${uname}'";	// uid の取得
    $R   = pg_query($con, $sql);
    $dat = pg_fetch_array($R, 0);
    $uid = $dat['uid'];

    foreach ($_POST as $key => $val) {
        if (substr($key, 0, 4) != 'item' || $val == 0) { continue; }
        $code = substr($key, 4) + 0;
        $sql = "INSERT INTO chumon (id, uid, code, num) VALUES ('${id}', '${uid}', '${code}', '${val}')";
        pg_query($con, $sql);
        $id++;
    }
    pg_close($con);
?>

注文完了しました

</body>
</html>
