<?php
function db_connect(): PDO|string {
    $host       = 'postgres';
    $dbname     = 'www';
    $user       = 'apache';
    $password   = 'passworda';
    try {
        $dsn = "pgsql:host=$host;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        return 'データベース接続エラー: ' . $e->getMessage();
    }
}

function executeStatement(PDO $pdo, string $sql, array $params = []): PDOStatement
{
    $statement = $pdo->prepare($sql);
    $statement->execute($params);

    return $statement;
}

function fetch(PDO $pdo, string $sql, array $parameters = []): mixed {
    $statement = executeStatement($pdo, $sql, $parameters);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function fetchAll(PDO $pdo, string $sql, array $parameters = []): array {
    $statement = executeStatement($pdo, $sql, $parameters);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function insert(PDO $pdo, string $table, array $data): mixed {
    $columns = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
    
    return executeStatement($pdo, $sql, $data);
}

function update(PDO $pdo, string $tableName, array $updateData, string $whereClause): PDOStatement
{
    $setClauses = [];
    foreach ($updateData as $columnName => $value) {
        $setClauses[] = sprintf('%s = :%s', $columnName, $columnName);
    }
    $updateSql = sprintf(
        'UPDATE %s SET %s WHERE %s',
        $tableName,
        implode(',', $setClauses),
        $whereClause
    );

    return executeStatement($pdo, $updateSql, $updateData);
}

function deleteStatement(PDO $pdo, string $tableName, string $whereClause): PDOStatement
{
    $deleteSql = sprintf('DELETE FROM %s WHERE %s', $tableName, $whereClause);
    return executeStatement($pdo, $deleteSql);
}
?>