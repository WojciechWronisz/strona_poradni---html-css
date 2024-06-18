<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twoja Strona</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<header id="main-header">
    <button onclick="history.back()" class="back-button">Powrót</button>
    <nav class="main-nav">
        <?php
        session_start();
        if (isset($_SESSION['pacjenci_id'])) {
            echo '<div class="auth-message">Jesteś zalogowany!</div>';
            echo '<form action="register.php" method="post">';
            echo '<input type="hidden" name="action" value="logout">';
            echo '<button type="submit" class="logout-button">Wyloguj się</button>';
            echo '</form>';
        } else {
            echo '<div class="auth-links">';
            echo '<a href="register.php" class="auth-link">Zaloguj</a>';
            echo '<a href="register.php" class="auth-link">Zarejestruj</a>';
            echo '</div>';
        }
        ?>
        <a href="html_poradnia.php" class="nav-link">Strona Główna</a>
        <a href="aktualnosci.php" class="nav-link">Aktualności</a>
        <a href="o_lekarzu.php" class="nav-link">Informacje o Lekarzu</a>
        <a href="kontakt.php" class="nav-link">Kontakt</a>
    </nav>
</header>
