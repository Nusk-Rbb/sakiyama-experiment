<?php
    include("db/db_manage.php");
    session_start();
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
        <img src="/img/chara.png">
        <div class="container">
            <h1>Niihama CTF</h1>
            <p>Welcome to Niihama CTF!!</p>
        </div>
        <nav>
            <ul>
                <?php
                    // Check for the cookie on every page load
                    try {
                        $pdo = db_connect();
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
                                <li><a href="/notice">Notice</a></li>
                                <li id="loginBtn"><a href="#">Login</a></li>
                                <li id="signupBtn"><a href="#">SignUp</a></li>
                            ';
                        }
                    } catch (PDOException $e) {
                        echo 'DB接続エラー: ' . $e->getMessage();
                    }
                    ?>
                    <li><a href="/admin">Admin</a></li>
            </ul>
        </nav>
    </header>

    <div class="main">
        <p>スコアサーバへの攻撃はおやめください</p>
        <p>フラグの形式は niihama{example} です。</p>
    </div>

    <!-- ログイン -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <form action="/login.php" method="post">
                <label for="username">ユーザー名</label><br>
                <input type="text" id="username" name="username" required><br><br>
                <label for="password">パスワード</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <input type="submit" value="ログイン">
            </form>
        </div>
    </div>

    <!-- サインアップ -->
    <div id="signupModal" class="modal">
        <div class="modal-content">
            <form action="/signup.php" method="post">
                <label for="new_username">ユーザー名</label><br>
                <input type="text" id="new_username" name="new_username" required><br><br>
                <label for="new_password">パスワード</label><br>
                <input type="password" id="new_password" name="new_password" required><br><br>
                <label for="confirm_password">パスワード(確認)</label><br>
                <input type="password" id="confirm_password" name="confirm_password" required><br><br>
                <input type="submit" value="サインアップ">
            </form>
        </div>
    </div>

    <!-- 通知 -->
    <?php
    if(isset($_SESSION['error_message'])) {
        echo '<p>エラー:' . $_SESSION['error_message'] . '</p><br>';
    }
    if(isset($_SESSION['message'])) {
        echo '<p>メッセージ:' . $_SESSION['message'] . '</p><br>';
    }
    ?>

    <script src="/js/script.js"></script>
</body>

</html>