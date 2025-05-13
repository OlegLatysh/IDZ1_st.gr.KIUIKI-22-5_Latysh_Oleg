<?php
$pdo = new PDO("sqlite:" . __DIR__ . "/log.sqlite");
$result = $pdo->query("SELECT * FROM logs ORDER BY timestamp DESC");

echo "<h2>Лог звернень</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Тип запиту</th><th>Параметр</th><th>Час</th></tr>";
foreach ($result as $row) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['query_type']}</td>
        <td>{$row['param_value']}</td>
        <td>{$row['timestamp']}</td>
    </tr>";
}
echo "</table>";
?>
