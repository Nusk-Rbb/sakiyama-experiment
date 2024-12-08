<?php

// ユーザ認証チェック

    $uname = $_POST['uname'];
    $pass  = $_POST['pass'];

    if ($uname == "" || $pass == "") { error_exit(2); }

    $con = dbstart( );
    $sql = "SELECT pass FROM kokyaku WHERE uname='${uname}'";
    $R   = pg_query($con, $sql);
    $dat = pg_fetch_array($R, 0);
    pg_close($con);
    if ($dat['pass'] != $pass) { error_exit(2); }

?>
