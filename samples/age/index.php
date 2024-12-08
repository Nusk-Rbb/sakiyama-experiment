<!DOCTYPE html">
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>年齢表</title>
</head>

<?php
    date_default_timezone_set('Asia/Tokyo');
    $today = getdate( );			// 今日の日付取得
    $year  = $today['year'];
    $month = $today['mon'];
    $day   = $today['mday'];
    $date  = $month * 100 + $day;
?>

<body>
<h2>年齢表（<?php print "${year}年${month}月${day}日現在"; ?>）</h2>

<table border="1">
<tr><th></th> <th>名前</th> <th>年齢</th></tr>
<?php
    $con = pg_connect("dbname='www' user='apache' password='passworda'");
    $sql = "SELECT * FROM user_tbl";
    $R   = pg_query($con, $sql);
    $rows = pg_num_rows($R);

    for ($i = 0; $i < $rows; $i++) {
        $dat = pg_fetch_array($R, $i);
        $uid   = $dat['id'];
        $name  = $dat['name'];
        $byear = (int)($dat['birth'] / 10000);
        $bdate = $dat['birth'] % 10000;
        $age = $year - $byear;
        if ($date < $bdate) { --$age; }
    print <<<_ENTRY
<tr><td><a href="detail.php?id=${uid}">${uid}</a></td> <td>${name}</td> <td>${age}歳</td></tr>

_ENTRY;
    }

    pg_free_result($R);
    pg_close($con);
?>
</table>

<a href="regist.php">新規登録</a>
<a href="query.php">検索</a>

</body>
</html>
