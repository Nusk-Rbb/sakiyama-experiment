<?php
session_start();
// セッション変数を破棄
session_unset();

// セッションファイルを削除
session_destroy();

// ログインページにリダイレクト
header('Location: /');
exit;
?>