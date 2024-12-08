<!DOCTYPE html">
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ユーザ検索</title>
</head>

<?php
    date_default_timezone_set('Asia/Tokyo');
    $today = getdate( );		// 今日の日付取得
    $year  = $today['year'];
    $month = $today['mon'];
    $day   = $today['mday'];
    $date  = $month * 100 + $day;
?>

<body>
<h2>ユーザ検索</h2>

<a href="index.php">戻る</a><br>
<form action="query.php" method="POST">
条件：年齢
<select name="comp" size="1">
  <option value="0" selected>＝</option>
  <option value="1">≧</option>
  <option value="2">≦</option>
</select>
<input type="text" name="age" size="5">
<input type="submit" value="検索">
</form>

<table border="1">
<tr><th></th> <th>名前</th> <th>生年月日</th> <th>年齢</th></tr>

<?php
    $where = "";
    if (isset($_POST['age']) && $_POST['age'] != "") {
        $day1 = ($year - $_POST['age']) * 10000 + $month * 100 + $day;
        $day2 = $day1 - 10000 + 1;
        switch ($_POST['comp']) {
        case 1:					// ≧
            $where = " WHERE birth <= '${day1}'";
            break;
        case 2:					// ≦
            $where = " WHERE birth >= '${day2}'";
            break;
        default:				// ＝
            $where = " WHERE birth BETWEEN '${day2}' AND '${day1}'";
            break;
        }
        $where .= " ORDER BY birth";
    }

    $con = pg_connect("dbname='www' user='apache' password='passworda'");
    $sql = "SELECT * FROM user_tbl" . $where;
    $R   = pg_query($con, $sql);
    $rows = pg_num_rows($R);

    for ($i = 0; $i < $rows; $i++) {
        $dat = pg_fetch_array($R, $i);
        $uid   = $dat['id'];
        $name  = $dat['name'];
        $birth = $dat['birth'];
        $byear  = (int)($birth / 10000);
        $bdate  = $birth % 10000;
        $bmonth = (int)($bdate / 100);
        $bday   = $birth % 100;

        $age = $year - $byear;
        if ($date < $bdate) { --$age; }
        print "<tr><td>${uid}</td> <td>${name}</td> <td>${byear}年${bmonth}月${bday}日</td> <td>${age}歳</td></tr>\n";
    }
    pg_free_result($R);
    pg_close($con);
?>
</table>

</body>
</html>
