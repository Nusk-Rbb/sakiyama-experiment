<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>PostgreSQL 検索テスト</title>
</head>

<body>

<?php
    // ＤＢサーバへの接続
    $con = pg_connect(" dbname='ＤＢ名' user='ユーザ名' password='パスワード' ");
    if (!$con){
        print "ＤＢサーバへの接続に失敗しました\n";
        exit;
    }

    // ＳＱＬ文の実行
    $sql = "SELECT * FROM sample_tbl";
    $R = pg_query($con, $sql);
    if (!$R){
	print "SQL: ${sql};<br>\n";
        print "テーブルの検索に失敗しました\n";
        exit;
    }

    // 検索結果の件数
    $rows = pg_num_rows($R);

    // 検索結果の表示
    for ($i = 0; $i < $rows; $i++){
        $data = pg_fetch_array($R, $i);		// i番目の結果取得
        print $data['uid'] . ", " . $data['name'] . ", " . $data['tel'] . "<br>\n";
        // print "${data['uid']}, ${data['name']}, ${data['tel']} <br>\n";
	// 上の print 文と同じ結果になる
    }

    // 検索結果の削除
    pg_free_result($R);

    // ＤＢサーバ切断
    pg_close($con);
?>

</body>
</html>

