<?php
try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/log.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            query_type TEXT,
            param_value TEXT,
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    echo " Базу даних log.sqlite створено успішно!";
} catch (PDOException $e) {
    echo " Помилка: " . $e->getMessage();
}
?>
