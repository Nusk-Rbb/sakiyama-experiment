<?php
function db_connect($host, $dbname, $user, $password): PDO|string {
    try {
        $dsn = "pgsql:host=$host;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        return 'データベース接続エラー: ' . $e->getMessage();
    }
}

function execute($pdo, $sql, $params = []): mixed {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

function fetch($pdo, $sql, $params = []): mixed {
    $stmt = execute($pdo, $sql, $params);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insert($pdo, $table, $data): void {
    $columns = implode(',', array_keys($data));
    $placeholders = ':' . implode(',:', array_keys($data));
    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    execute($pdo, $sql, $data);
}
?>