<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktualności - Poradnia Lekarska</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<div class="news-container">
    <?php
    // Połączenie z bazą danych
    $dsn = 'mysql:host=localhost;dbname=Pacjenci;charset=utf8';
    $username = 'Wojtek';
    $password = '123';

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Pobranie danych z tabeli aktualnosci
        $stmt = $pdo->query('SELECT * FROM aktualnosci');
        $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Wyświetlenie aktualności
        foreach ($news as $new) {
            echo '<article class="news-item">';
            echo '<h2>' . htmlspecialchars($new['tytul']) . '</h2>';
            echo '<p>' . htmlspecialchars($new['zawartosc']) . '</p>';
            // Jeśli nie masz daty publikacji, nie wyświetlamy tego pola
            echo '</article>';
        }
    } catch (PDOException $e) {
        echo 'Błąd połączenia z bazą danych: ' . $e->getMessage();
    }
    ?>
</div>

</body>
</html>

<?php include 'footer.php'; ?>
