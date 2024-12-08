<!DOCTYPE html">
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>注文履歴</title>
</head>

<body>

<?php
    include('./common.php');
    include('./authcheck.php');			// ユーザ認証
?>

<h2>注文履歴</h2>

<form action="login.php" method="POST">
<input type="hidden" name="uname" value="<?php echo $uname; ?>">
<input type="hidden" name="pass" value="<?php echo $pass; ?>">
<input type="submit" value="戻る">
</form>

<?php
    $con = dbstart( );
    $sql = "SELECT name, price, num, price * num AS total FROM shohin, chumon WHERE shohin.code=chumon.code AND uid=(SELECT uid FROM kokyaku WHERE uname='${uname}') ORDER BY id";
    $R   = pg_query($con, $sql);
    $rows = pg_num_rows($R);

    if ($rows > 0) {
        print <<< _HEAD
<table border="1">
<tr><th>商品名</th> <th>単価</th> <th>個数</th> <th>金額</th></tr>

_HEAD;

        for ($i = 0; $i < $rows; $i++) {
            $dat = pg_fetch_array($R, $i);
            print "<tr><td>${dat['name']}</td> <td align=\"right\">${dat['price']}</td> <td align=\"right\">${dat['num']}</td> <td align=\"right\">${dat['total']}</td></tr>\n";
        }
        print "</table>\n";
    } else {
        print "商品購入履歴がありません<br>\n";
    }
?>

</body>
</html>
