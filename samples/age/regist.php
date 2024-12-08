<!DOCTYPE html">
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>新規登録</title>
</head>

<body>
<h2>新規登録</h2>

<?php
    if ($_POST['id'] != "" && $_POST['name'] != "" &&
        $_POST['year'] != "" && $_POST['month'] != "" && $_POST['day'] != "") {
        $birth = $_POST['year'] * 10000 + $_POST['month'] * 100 + $_POST['day'];
        $con = pg_connect("dbname='www' user='apache' password='passworda'");
        $sql = "INSERT INTO user_tbl (id, name, birth) VALUES ('${_POST['id']}', '${_POST['name']}', '${birth}')";
        $R   = pg_query($con, $sql);
        pg_close($con);
        print "登録しました<br>\n";
    }
?>

<form action="regist.php" method="POST">
<table>
<tr><th>ＩＤ</th> <td><input type="text" name="id" size="4"></td></tr>
<tr><th>名前</th> <td><input type="text" name="name" size="10"></td></tr>
<tr><th>誕生年</th> <td><input type="text" name="year" size="5"></td></tr>
<tr><th>誕生月</th> <td><input type="text" name="month" size="5"></td></tr>
<tr><th>誕生日</th> <td><input type="text" name="day" size="5"></td></tr>
</table>
<input type="submit" value="登録">
<a href="index.php">戻る</a>
</form>

</body>
</html>
