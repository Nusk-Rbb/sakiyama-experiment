<!DOCTYPE html">
<html lang="ja">
<head>
<meta charset="UTF-8">
<head>
<title>詳細表示</title>
</head>

<body>
<?php
    $uid = $_GET['id'];
    if ($uid == "") {
        print "ユーザが指定されていません！<br>\n";
        print "</body>\n</html>\n";
        exit;
    }
    $con = pg_connect("dbname='www' user='apache' password='passworda'");
    $sql = "SELECT * FROM user_tbl WHERE id='${uid}'";
    $R   = pg_query($con, $sql);
    $dat = pg_fetch_array($R, 0);
    pg_close($con);

    $uid   = $dat['id'];
    $name  = $dat['name'];
    $birth = $dat['birth'];		// 誕生日の取得
    $byear  = (int)($birth / 10000);
    $bdate  = $birth % 10000;
    $bmonth = (int)($bdate / 100);
    $bday   = $birth % 100;

    date_default_timezone_set('Asia/Tokyo');
    $today = getdate( );		// 今日の日付の取得
    $year  = $today['year'];
    $month = $today['mon'];
    $day   = $today['mday'];
    $date  = $month * 100 + $day;

    $age = $year - $byear;		// 現在の年齢の計算
    if ($date < $bdate) { --$age; }
?>

<h2>ユーザ情報</h2>

<table border="1">
<tr><th>ＩＤ</th> <td><input type="text" value="<?php echo $uid; ?>"></td></tr>
<tr><th>名前</th> <td><input type="text" value="<?php echo $name; ?>"></td></tr>
<tr><th>生年月日</th> <td>
<input type="text" size="5" value="<?php echo $byear; ?>">年
<input type="text" size="3" value="<?php echo $bmonth; ?>">月
<input type="text" size="3" value="<?php echo $bday; ?>">日</td></tr>
<tr><th>年齢</th> <td><?php echo $age; ?>歳</td></tr>
</table>

<a href="index.php">戻る</a>

</body>
</html>
