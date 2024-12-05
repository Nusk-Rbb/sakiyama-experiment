<?php
    include("db/db_manage.php");
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
    <body>
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
                    try {
                        $pdo = db_connect('postgres', 'www', 'apache', 'passworda');
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                            // User is logged in, set session variables
                            $sql = "SELECT * FROM users WHERE user_id = :user_id";
                            $user = fetch($pdo, $sql, ['user_id' => $user_id]);

                            $sql = "SELECT * FROM scores WHERE user_id = :user_id";
                            $score = fetch($pdo, $sql, ['user_id' => $user_id]);

                            if($user && $score) {
                                $_SESSION['username'] = $user['username'];
                                $_SESSION['score'] = $score['score'];
                                print '
                                    <li><a href="/challenges">Challenges</a></li>
                                    <li><a href="/ranking">Ranking</a></li>
                                    <li><a href="/notice">Notice</a></li>
                                    <li><a href="/dashboard.php">'. $_SESSION['username'] . '</a></li>
                                    <li><a href="#">Score ' . $_SESSION['score'] . '</a></li>
                                    <li><a href="/logout.php">Logout</a></li>
                                ';
                            }
                        } else {
                            // User is not logged in
                            print '
                                <li><a href="#">Notice</a></li>
                                <li id="loginBtn"><a href="#">Login</a></li>
                                <li id="signupBtn"><a href="#">SignUp</a></li>
                            ';
                        }
                    } catch (PDOException $e) {
                        echo 'DB接続エラー: ' . $e->getMessage();
                    }
                    ?>
                </ul>
            </nav>
        </header>

        <div class="container">
            <?php
                echo '<h2>ようこそ ' . $_SESSION['username'] . ' さん</h2>';
            ?>
            <p>フラグの形式は niihama{example} です。</p>
        </div>

        <!-- 通知 -->
        <div id="notificationModal" class="modal">
            <div class="modal-content">
                <?php
                    if(isset($_SESSION['error_message'])) {
                        echo '<p>エラー:' . $_SESSION['error_message'] . '</p><br>';
                    }
                    if(isset($_SESSION['message'])) {
                        echo '<p>メッセージ:' . $_SESSION['message'] . '</p><br>';
                    }
                ?>
            </div>
        </div>

        <script src="js/script.js"></script>
    </body>
</html>