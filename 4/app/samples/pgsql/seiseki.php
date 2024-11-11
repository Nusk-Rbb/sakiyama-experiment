<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>成績管理システム</title>
</head>

<body>

<h2>成績管理システム</h2>

<form action="seiseki.php" method="POST">
ユーザＩＤ
<input type="text" name="uid" size="10">
名前
<input type="text" name="name" size="20">
点数
<input type="text" name="score" size="8">
<input type="submit" name="search" value="検索">
<a href="touroku.php">登録</a>
</form>

<?php

    if (!isset($_POST['search'])) {		// 何もボタンが押されていない場合
        exit;
    }

// 検索

// ＳＱＬ文の作成
    $sql   = "SELECT * FROM seiseki_tbl";	// 全検索のＳＱＬ文
    $where = " WHERE '1'='1'";			// 常時成立する条件

    if ($_POST['uid'] != "") {				// ユーザＩＤの条件追加
        $where .= " AND uid='${_POST['uid']}'";		// ' AND uid=〜 '
    }
    if ($_POST['name'] != "") {				// 名前の条件追加
        $where .= " AND name='${_POST['name']}'";	// ' AND name=〜 '
    }
    if ($_POST['score'] != "") {			// 点数の条件追加
        $where .= " AND score='${_POST['score']}'";	// ' AND score=〜 '
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
        print "<tr><th>ユーザＩＤ</th> <th>名前</th> <th>点数</th></tr>\n";
    }
    for ($i = 0; $i < $rows; $i++){
        $data = pg_fetch_array($R, $i);
        print "<tr><td>${data['uid']}</td> <td>${data['name']}</td> <td>${data['score']}</td></tr>\n";
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
