<!DOCTYPE html">
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品購入</title>
</head>

<body>

<?php
    include('./common.php');
    include('./authcheck.php');			// ユーザ認証
?>

<h2>商品購入</h2>

<form action="login.php" method="POST">
<input type="hidden" name="uname" value="<?php echo $uname; ?>">
<input type="hidden" name="pass" value="<?php echo $pass; ?>">
<input type="submit" value="戻る">
</form>

<form action="order2.php" method="POST">
<input type="hidden" name="uname" value="<?php echo $uname; ?>">
<input type="hidden" name="pass" value="<?php echo $pass; ?>">
<table border="1">
<tr><th>商品名</th> <th>価格</th> <th>注文数</th></tr>

<?php
    $con = dbstart( );
    $sql = "SELECT * FROM shohin WHERE stock > '0' ORDER BY code";
    $R   = pg_query($con, $sql);
    $rows = pg_num_rows($R);

    for ($i = 0; $i < $rows; $i++) {
        $dat = pg_fetch_array($R, $i);
        print "<tr><td>${dat['name']}</td> <td>${dat['price']}</td> <td>\n";
        print "<select name=\"item${dat['code']}\" size=\"1\">\n";
        print "  <option value=\"0\">−</option>\n";
        $max = ($dat['stock'] >= 10) ? 10 : $dat['stock'];
        for ($j = 1; $j <= $max; $j++) {
            print "  <option value=\"${j}\">${j}</option>\n";
        }
        print "</select></td></tr>\n";
    }
    pg_free_result($R);
    pg_close($con);
?>

</table>
<input type="submit" value="注文">
</form>

</body>
</html>
