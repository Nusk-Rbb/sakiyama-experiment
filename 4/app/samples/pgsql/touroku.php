<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>成績管理システム</title>
</head>

<body>

<h2>成績管理システム データ登録</h2>

<form action="touroku.php" method="POST">
ユーザＩＤ
<input type="text" name="uid" size="10">
名前
<input type="text" name="name" size="20">
点数
<input type="text" name="score" size="8">
<input type="submit" name="regist" value="登録">
<a href="seiseki.php">戻る</a>
</form>

<?php

    if (!isset($_POST['regist'])) {		// 何もボタンが押されていない場合
        exit;
    }

// 登録

    if ($_POST['uid']   == "" ||
	$_POST['name']  == "" ||
	$_POST['score'] == ""   ) {
        print "登録するときは全ての項目へ入力してください！<br>\n";
        exit;
    }
    $uid   = $_POST['uid'];
    $name  = $_POST['name'];
    $score = $_POST['score'];

// ＳＱＬ文の作成
    $sql = "INSERT INTO seiseki_tbl (uid, name, score) "
	 . "VALUES ('${uid}', '${name}', '${score}')";

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

// 検索結果の削除
    pg_free_result($R);

// 登録したデータを検索してみる
    $sql = "SELECT * FROM seiseki_tbl "
	 . "WHERE uid='${uid}' AND name='${name}' AND score='${score}'";

// デバッグ用（作成されたＳＱＬ文を画面表示）
//    print "SQL: ${sql}<br>\n";

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

    print "このデータを登録しました<br>\n";

// 検索結果の削除
    pg_free_result($R);

// ＤＢサーバ切断
    pg_close($con);

?>

</body>
</html>
