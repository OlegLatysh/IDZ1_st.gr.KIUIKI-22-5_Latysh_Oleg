<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Фільмотека</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Обрати фільми за жанром</h2>
<form action="search.php" method="GET">
    <select name="genre">
        <?php
        $query = $pdo->query("SELECT * FROM genre");
        while ($row = $query->fetch()) {
            echo "<option value='{$row['ID_Genre']}'>{$row['title']}</option>";
        }
        ?>
    </select>
    <button type="submit" name="search_genre">Знайти</button>
</form>

<h2>Обрати фільми за актором</h2>
<form action="search.php" method="GET">
    <select name="actor">
        <?php
        $query = $pdo->query("SELECT * FROM actor");
        while ($row = $query->fetch()) {
            echo "<option value='{$row['ID_Actor']}'>{$row['name']}</option>";
        }
        ?>
    </select>
    <button type="submit" name="search_actor">Знайти</button>
</form>

<h2>Обрати фільми за датою</h2>
<form action="search.php" method="GET">
    <select name="start_date">
        <?php
        $query = $pdo->query("SELECT DISTINCT date FROM film ORDER BY date ASC");
        while ($row = $query->fetch()) {
            echo "<option value='{$row['date']}'>{$row['date']}</option>";
        }
        ?>
    </select>
    <select name="end_date">
        <?php
        $query = $pdo->query("SELECT DISTINCT date FROM film ORDER BY date DESC");
        while ($row = $query->fetch()) {
            echo "<option value='{$row['date']}'>{$row['date']}</option>";
        }
        ?>
    </select>
    <button type="submit" name="search_time">Знайти</button>
</form>

</body>
</html>
