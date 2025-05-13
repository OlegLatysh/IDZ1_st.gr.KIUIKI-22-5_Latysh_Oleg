<?php
include 'db.php';
include 'log.php';
$movies = [];

if (isset($_GET['search_genre'])) {
    $stmt = $pdo->prepare("
        SELECT film.*, 
               GROUP_CONCAT(DISTINCT genre.title SEPARATOR ', ') AS genres,
               GROUP_CONCAT(DISTINCT actor.name SEPARATOR ', ') AS actors
        FROM film
        JOIN film_genre ON film.ID_FILM = film_genre.FID_Film
        JOIN genre ON film_genre.FID_Genre = genre.ID_Genre
        LEFT JOIN film_actor ON film.ID_FILM = film_actor.FID_Film
        LEFT JOIN actor ON film_actor.FID_Actor = actor.ID_Actor
        WHERE genre.ID_Genre = ?
        GROUP BY film.ID_FILM
    ");
    $stmt->execute([$_GET['genre']]);
    log_query("genre", $_GET['genre']);
    $movies = $stmt->fetchAll();
}

if (isset($_GET['search_actor'])) {
    $stmt = $pdo->prepare("
        SELECT film.*, 
               GROUP_CONCAT(DISTINCT genre.title SEPARATOR ', ') AS genres,
               GROUP_CONCAT(DISTINCT actor.name SEPARATOR ', ') AS actors
        FROM film
        LEFT JOIN film_genre ON film.ID_FILM = film_genre.FID_Film
        LEFT JOIN genre ON film_genre.FID_Genre = genre.ID_Genre
        JOIN film_actor ON film.ID_FILM = film_actor.FID_Film
        JOIN actor ON film_actor.FID_Actor = actor.ID_Actor
        WHERE actor.ID_Actor = ?
        GROUP BY film.ID_FILM
    ");
    $stmt->execute([$_GET['actor']]);
    log_query("actor", $_GET['actor']);
    $movies = $stmt->fetchAll();
}

if (isset($_GET['search_time'])) {
    $stmt = $pdo->prepare("
        SELECT film.*, 
               GROUP_CONCAT(DISTINCT genre.title SEPARATOR ', ') AS genres,
               GROUP_CONCAT(DISTINCT actor.name SEPARATOR ', ') AS actors
        FROM film
        LEFT JOIN film_genre ON film.ID_FILM = film_genre.FID_Film
        LEFT JOIN genre ON film_genre.FID_Genre = genre.ID_Genre
        LEFT JOIN film_actor ON film.ID_FILM = film_actor.FID_Film
        LEFT JOIN actor ON film_actor.FID_Actor = actor.ID_Actor
        WHERE film.date BETWEEN ? AND ?
        GROUP BY film.ID_FILM
    ");
    $stmt->execute([$_GET['start_date'], $_GET['end_date']]);
    log_query("date_range", $_GET['start_date'] . " - " . $_GET['end_date']);
    $movies = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Результати</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Результати пошуку </h2>
<table>
    <tr>
        <th>Назва</th>
        <th>Дата</th>
        <th>Країна</th>
        <th>Режисер</th>
        <th>Жанри</th>
        <th>Актори</th>
    </tr>
    <?php if (!empty($movies)): ?>
        <?php foreach ($movies as $movie): ?>
            <tr>
                <td><?= htmlspecialchars($movie['name']) ?></td>
                <td><?= htmlspecialchars($movie['date']) ?></td>
                <td><?= htmlspecialchars($movie['country']) ?></td>
                <td><?= htmlspecialchars($movie['director']) ?></td>
                <td><?= htmlspecialchars($movie['genres']) ?></td>
                <td><?= htmlspecialchars($movie['actors']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="6">Фільми не знайдені</td></tr>
    <?php endif; ?>
</table>

<a href="index.php"> Назад</a>

</body>
</html>
