<!DOCTYPE html">
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>会員ページ</title>
</head>

<body>

<?php
    include('./common.php');
    include('./authcheck.php');			// ユーザ認証
?>

<h2>登録会員ページ</h2>

<form action="order.php" method="POST">
<input type="hidden" name="uname" value="<?php echo $uname; ?>">
<input type="hidden" name="pass" value="<?php echo $pass; ?>">
<li>買い物ページへ<input type="submit" value="移動">
</form>

<form action="history.php" method="POST">
<input type="hidden" name="uname" value="<?php echo $uname; ?>">
<input type="hidden" name="pass" value="<?php echo $pass; ?>">
<li>注文履歴を<input type="submit" value="見る">
</form>

</body>
</html>
