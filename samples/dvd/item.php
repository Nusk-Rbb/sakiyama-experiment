<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>新規登録</title>
</head>

<body>
<a href="list.php">戻る</a><br>

<form action="item_new.php" method="POST">
<table>
<tr><td>ＩＤ</td> <td><input type="text" name="id" size="5"></td></tr>
<tr><td>タイトル</td> <td><input type="text" name="title" size="20"></td></tr>
<tr><td>メーカ名</td> <td><select name="mid" size="1">
<option value="---">１つ選択</option>
<?php
    $con = pg_connect("dbname='www' user='apache' password='passworda'");
    $sql = "SELECT * FROM dvdtable2";
    $R = pg_query($con, $sql);
    $rows = pg_num_rows($R);
    for ($i = 0; $i < $rows; $i++){
        $data = pg_fetch_array($R, $i);
        print "<option value=\"${data['mid']}\">${data['maker']}</option>\n";
    }
    pg_free_result($R);
    pg_close($con);
?>
</select></td></tr>
</table>
<input type="submit" value="登録">
</form>

</body>
</html>
