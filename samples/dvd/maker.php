<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>メーカ一覧</title>
</head>

<body>
<h3>メーカ一覧</h3>

<a href="list.php">戻る</a><br>

<table border="1">
<tr><th>メーカＩＤ</th> <th>メーカ名</th></tr>
<?php
    $con = pg_connect("dbname='www' user='apache' password='passworda'");
    $sql = "SELECT * FROM dvdtable2";
    $R = pg_query($con, $sql);
    $rows = pg_num_rows($R);
    for ($i = 0; $i < $rows; $i++){
        $data = pg_fetch_array($R, $i);
        print "<tr><td>${data['mid']}</td> <td>${data['maker']}</td></tr>\n";
    }
    pg_free_result($R);
    pg_close($con);
?>
</table>

新規登録<br>
<form action="maker_new.php" method="POST">
<table>
<tr><td>メーカＩＤ</td> <td><input type="text" name="mid" size="5"></td></tr>
<tr><td>メーカ名</td> <td><input type="text" name="maker" size="20"></td></tr>
</table>
<input type="submit" value="登録">
</form>

</body>
</html>
