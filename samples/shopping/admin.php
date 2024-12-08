<!DOCTYPE html">
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>店員トップページ</title>
</head>

<body>
<h2>店員専用ページ</h2>

<ul>
<li><a href="item.html">商品新規登録</a></li>
<li>注文履歴</li>
<li>顧客リスト</li>
</ul>

<table border="1">
<tr><th>商品名</th> <th>価格</th> <th>在庫数</th> <th>在庫追加</th></tr>

<?php
    include('./common.php');

// 在庫追加処理があった場合
    if ($_POST['code'] != "" and $_POST['num'] != "") {
        $code = $_POST['code'];
        $con  = dbstart( );
        $sql  = "SELECT stock FROM shohin WHERE code='${code}'";
        $R    = pg_query($con, $sql);
        $data = pg_fetch_array($R, 0);
        $num  = $data['stock'] + $_POST['num'];
        $sql  = "UPDATE shohin SET stock='${num}' WHERE code='${code}'";
        $R    = pg_query($con, $sql);
        pg_close($con);
    }

    $con  = dbstart( );
    $sql  = "SELECT * FROM shohin ORDER BY code";
    $R    = pg_query($con, $sql);
    $rows = pg_num_rows($R);

    for ($i = 0; $i < $rows; $i++) {
        $data = pg_fetch_array($R, $i);
        print <<<_ROWS
<tr><td>${data['name']}</td> <td>${data['price']}</td> <td>${data['stock']}</td>
<td><form action="admin.php" method="POST">
<input type="hidden" name="code" VALUE="${data['code']}">
<input type="text"   name="num" size="5">
<input type="submit" VALUE="追加"></form></td></tr>

_ROWS;
    }

    pg_free_result($R);
    pg_close($con);
?>

</table>

</body>
</html>
