<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題35</title>
</head>

<body>

<h2>課題35</h2>

<form action="index.php" method="POST">
学校ID
<input type="text" name="sid" size="10">
学校名
<input type="text" name="school" size="20">
市
<input type="text" name="city" size="10">
<input type="submit" name="search" value="検索">
</form>

<?php

    if (!isset($_POST['search'])) {		// 何もボタンが押されていない場合
        exit;
    }

// 検索

// ＳＱＬ文の作成
    $sql   = "SELECT school_table.sid, school_table.school, city_table.city FROM school_table INNER JOIN city_table ON school_table.cid = city_table.cid";	// 全検索のＳＱＬ文
    $where = " AND 1=1";			// 常時成立する条件

    if ($_POST['sid'] != "") {				// ユーザＩＤの条件追加
        $where .= " AND school_table.sid='${_POST['sid']}'";		// ' AND uid=〜 '
    }
    if ($_POST['school'] != "") {				// 名前の条件追加
        $where .= " AND school_table.school='${_POST['school']}'";	// ' AND name=〜 '
    }
    if ($_POST['city'] != "") {			// 点数の条件追加
        $where .= " AND city_table.city='${_POST['city']}'";	// ' AND score=〜 '
    }

    $sql = $sql . $where;

// デバッグ用（作成されたＳＱＬ文を画面表示）
//    print "SQL: ${sql}<br>\n";

// ＤＢサーバへの接続
    $con = pg_connect("host=postgres port=5432 dbname='www' user='apache' password='passwordp'");
    if (!$con){
        print "ＤＢサーバへの接続に失敗しました<br>\n";
        exit;
    }

// ＳＱＬ文の実行
    $R = pg_query($con, $sql);
    if (!$R){
        print "SQL: ${sql};<br>\n";
        print "テーブルの検索に失敗しました<br>\n";
        exit;
    }

// 検索結果の件数
    $rows = pg_num_rows($R);

// 検索結果の表示（表形式）
    if ($rows > 0){
        print "<table border=\"1\">\n";
        print "<tr><th>学校ID</th> <th>学校名</th> <th>市</th></tr>\n";
    }
    for ($i = 0; $i < $rows; $i++){
        $data = pg_fetch_array($R, $i);
        print "<tr><td>${data['sid']}</td> <td>${data['school']}</td> <td>${data['city']}</td></tr>\n";
    }
    if ($rows > 0){
        print "</table>\n";
    } else {
        print "そのようなデータは登録されていません<br>\n";
    }

// 検索結果の削除
    pg_free_result($R);

// ＤＢサーバ切断
    pg_close($con);

?>

</body>
</html>
