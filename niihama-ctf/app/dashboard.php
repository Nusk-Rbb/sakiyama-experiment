<?php
// ログイン状態のチェック
if (isset($_SESSION['user_id'])) {
    // ログイン済み
    echo 'ようこそ、' . $_SESSION['username'] . 'さん！';
} else {
    // ログインしていない
    echo 'ログインしてください。';
}
?>