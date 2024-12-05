<?php
    include("login.php");
    include("signup.php");
    include("notification.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Niihama CTF</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <header>
            <a href="/"><img src="img/chara.png"></a>
            <div class="container">
                <h1>Niihama CTF</h1>
                <p>Welcome to Niihama CTF!!</p>
            </div>
            <nav>
                <ul>
                    <?php
                    // Check for the cookie on every page load
                    try{
                        $pdo = new PDO("pgsql:host=postgres;dbname=www", "apache", "passworda");
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                            // User is logged in, set session variables
                            $user_query = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
                            $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
                            $stmt->execute();

                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            if($user) {
                                $_SESSION['username'] = $user['username'];
                                $_SESSION['score'] = $user['score'];
                                print '
                                    <li><a href="#">Challenges</a></li>
                                    <li><a href="#">Difficulty</a></li>
                                    <li><a href="#">Ranking</a></li>
                                    <li><a href="#">Notice</a></li>
                                    <li><a href="dashboard.php">'. $_SESSION['username'] . '</a></li>
                                    <li><a href="#">Score ' . $_SESSION['score'] . '</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                ';
                            }
                            // User is not logged in
                            print '
                                <li><a href="#">Notice</a></li>
                                <li id="loginBtn"><a href="#">Login</a></li>
                                <li id="signupBtn"><a href="#">SignUp</a></li>
                            ';
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
            <p>スコアサーバへの攻撃はおやめください</p>
            <p>フラグの形式は niihama{example} です。</p>
            <?php
                if(isset($_SESSION['error_message'])) {
                    echo '<p>エラー:' . $_SESSION['error_message'] . '</p><br>';
                }
                if(isset($_SESSION['message'])) {
                    echo '<p>メッセージ:' . $_SESSION['message'] . '</p><br>';
                }
            ?>
        </div>

        <!-- ログイン -->
        <div id="loginModal" class="modal">
            <div class="modal-content">
                <form action="login.php" method="post">
                    <label for="username">ユーザー名:</label><br>
                    <input type="text" id="username" name="username"
                        required><br><br>
                    <label for="password">パスワード:</label><br>
                    <input type="password" id="password" name="password"
                        required><br><br>
                    <input type="submit" value="ログイン">
                </form>
            </div>
        </div>

        <!-- サインアップ -->
        <div id="signupModal" class="modal">
            <div class="modal-content">
                <form action="signup.php" method="post">
                    <label for="new_username">ユーザー名:</label><br>
                    <input type="text" id="new_username" name="new_username"
                        required><br><br>
                    <label for="new_password">パスワード:</label><br>
                    <input type="password" id="new_password" name="new_password"
                        required><br><br>
                    <label for="confirm_password">パスワード(確認):</label><br>
                    <input type="password" id="confirm_password"
                        name="confirm_password" required><br><br>
                    <input type="submit" value="サインアップ">
                </form>
            </div>
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