<!DOCTYPE html">
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ユーザ新規登録</title>
</head>

<body>

<?php
    include('./common.php');

    if ($_POST{'uname'} == "" || $_POST{'pass'}    == "" ||
        $_POST{'name'}  == "" || $_POST{'address'} == ""   ) {
        error_exit(1);
    }

    $uname   = $_POST{'uname'};
    $pass    = $_POST{'pass'};
    $name    = $_POST{'name'};
    $address = $_POST{'address'};

    $con = dbstart( );
    $sql = "SELECT MAX(uid) FROM kokyaku";	// uid の自動作成
    $R   = pg_query($con, $sql);
    $dat = pg_fetch_array($R, 0);
    $uid = ($dat[0] == 0) ? 1 : $dat[0] + 1;
    pg_free_result($R);

    $sql = "INSERT INTO kokyaku VALUES (${uid}, '${uname}', '${pass}', '${name}', '${address}')";
    $R   = pg_query($con, $sql);
    pg_close($con);
?>

登録完了しました<br><br>

<a href="index.html">戻る</a>

</body>
</html>
