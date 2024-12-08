<?php

function dbstart( ) {		// データベース接続関数

    $con = pg_connect("dbname='www' user='apache' password='passworda'");
    if (!$con) {
        print "データベースへの接続に失敗しました！<br>\n</body>\n</html>\n";
        exit;
    }
    return $con;
}

function error_exit($errno) {		// エラー処理関数

    switch ($errno) {
    case 1:				// 入力項目不足
        print <<< _ERROR1
すべての項目に入力をしてください！<br><br>
<a href="javascript:history.back()">戻る</a>
</body>
</html>
_ERROR1;
        break;

    case 2:				// ユーザ認証失敗
        print <<< _ERROR2
ユーザ名またはパスワードが違います！<br><br>
<a href="index.html">戻る</a>
</body>
</html>
_ERROR2;
        break;
   }
    exit;
}

?>
