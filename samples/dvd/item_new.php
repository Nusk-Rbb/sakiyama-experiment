<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>登録完了</title>
</head>

<body>

<?php

// すべてのエラー処理省略

    $con = pg_connect("dbname='www' user='apache' password='passworda'");
    $sql = "INSERT INTO dvdtable1 (id, title, mid) VALUES ('${_POST['id']}', '${_POST['title']}', '${_POST['mid']}')";
    pg_query($con, $sql);
    pg_free_result($R);
    pg_close($con);
?>

登録完了しました<br>
<a href="list.php">戻る</a>
</body>
</html>
