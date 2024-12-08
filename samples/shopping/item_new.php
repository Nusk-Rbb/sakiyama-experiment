<!DOCTYPE html">
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品登録ページ</title>
</head>

<body>

<?php
    include('./common.php');

    if ($_POST['code']  == "" || $_POST['name']  == "" ||
        $_POST['price'] == "" || $_POST['stock'] == ""   ) {
        error_exit(1);
    }

    $code  = $_POST['code'] + 0;
    $name  = $_POST['name'] . "";
    $price = $_POST['price'] + 0;
    $stock = $_POST['stock'] + 0;

    $con = dbstart( );
    $sql = "INSERT INTO shohin (code, name, price, stock) VALUES ('${code}', '${name}', '${price}', '${stock}')";
    $R   = pg_query($con, $sql);
    pg_close($con);
?>

登録完了しました<br><br>

<a href="admin.php">戻る</a>

</body>
</html>
