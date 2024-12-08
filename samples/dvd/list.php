<!DOCTYPE html">
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>所有ＤＶＤリスト</title>
</head>

<body>
<h2>所有ＤＶＤリスト</h2>

<table border="1">
<tr>
<th>ＩＤ</th> <th>タイトル</th> <th><a href="maker.php">メーカ名</a></th>
</tr>

<?php

// ＤＢサーバへ接続
    $con = pg_connect("dbname='www' user='apache' password='passworda'");
    if (!$con){
        print "</table>\nＤＢサーバへの接続に失敗しました\n</body></html>\n";
        exit;
    }

// 登録データ検索
    $sql = "SELECT id, title, maker FROM dvdtable1, dvdtable2 WHERE dvdtable1.mid = dvdtable2.mid";
    $R = pg_query($con, $sql);
    $rows = pg_num_rows($R);

// 登録データの表示
    if ($rows > 0){
        for ($i = 0; $i < $rows; $i++){
            $data = pg_fetch_array($R, $i);
            print "<tr><td>${data['id']}</td> <td>${data['title']}</td> <td>${data['maker']}</td></tr>\n";
        }
    }

// ＤＢサーバ切断
    pg_free_result($R);
    pg_close($con);
?>

</table>

<a href="item.php">新規登録</a>
</body>
</html>
