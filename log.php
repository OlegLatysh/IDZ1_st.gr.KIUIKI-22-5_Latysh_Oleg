<?php
function log_query($type, $param) {
    try {
        $pdo_sqlite = new PDO("sqlite:" . __DIR__ . "/log.sqlite");
        $pdo_sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo_sqlite->prepare("INSERT INTO logs (query_type, param_value) VALUES (?, ?)");
        $stmt->execute([$type, $param]);
    } catch (PDOException $e) {
        error_log("Помилка логування: " . $e->getMessage());
    }
}
?>
