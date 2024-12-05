<?php
    include("../db/db_manage.php");
    // 認証処理
    session_start();
    if (!isset($_SESSION['logged_in'])) {
        header('WWW-Authenticate: Basic realm="Restricted Area"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'You are not authorized to access this page';
        exit;
    }
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Niihama CTF</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <header>
        <a href="/"><img src="/img/chara.png"></a>
        <div class="container">
            <h1>Niihama CTF</h1>
            <p>Welcome to Niihama CTF!!</p>
        </div>
        <nav>
            <ul>
                <?php
                // Check for the cookie on every page load
                print '
                    <li><a href="/challenges">Challenges</a></li>
                    <li><a href="/ranking">Ranking</a></li>
                    <li><a href="/notice">Notice</a></li>
                    <li><a href="/dashboard.php">'. $_SESSION['username'] . '</a></li>
                    <li><a href="#">Score ' . $_SESSION['score'] . '</a></li>
                    <li><a href="/logout.php">Logout</a></li>
                ';
                ?>
            </ul>
        </nav>
    </header>
    <body>
        <div class="container">
            <h1>Challenges</h1>
            <p>Coming soon...</p>
        </div>
    </body>
</html>