<?php
include_once("../../db/db_manage.php");

if($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $username = $_PUT['username'];
    $column = $_PUT['column'];
    $value = $_PUT['value'];
    echo $value;
    try {
        $pdo = db_connect();

        if($column === "password"){
            update($pdo, "users", ["password" => password_hash($value, PASSWORD_DEFAULT)], "username = :username");
        } else {
            update($pdo, "users", ["username" => $value], "username = :username");
        }
        if($update){
            header("Location: index.php");
        } else {
            echo "更新に失敗しました";
        }
    } catch (PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
}

if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    try {
        $pdo = db_connect();

        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $users = fetchAll($pdo, $sql, ["user_id" => $_DELETE['user_id']]);
        if($users){
            echo "削除に成功しました";
        } else {
            echo "削除に失敗しました";
        }
    } catch (PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = db_connect();

        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $users = fetchAll($pdo, $sql, ["username" => $_PUT['username'], "password" => $_PUT['password']]);
        if($users){
            echo "登録に成功しました";
        } else {
            echo "登録に失敗しました";
        }
    } catch (PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }
}
?>