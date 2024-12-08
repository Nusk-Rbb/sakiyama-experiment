<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>登録完了</title>
</head>

<body>

<?php
    $con = pg_connect("dbname='www' user='apache' password='passworda'");
    $sql = "INSERT INTO dvdtable2 (mid, maker) VALUES ('${_POST['mid']}', '${_POST['maker']}')";
    pg_query($con, $sql);
    pg_free_result($R);
    pg_close($con);
?>

登録完了しました<br>
<a href="list.php">戻る</a>
</body>
</html>
