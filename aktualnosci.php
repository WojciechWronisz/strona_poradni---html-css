<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktualności - Poradnia Lekarska</title>
    <link rel="stylesheet" href="css_aktualnosci.css">
    <script> //javascript
    function goBack() {
        window.history.back();
    }
    </script>
</head>
<body>
<header id="main-header">
    <button onclick="goBack()" class="back-button">Powrót</button>
    <div class="auth-links">
        <a href="register.php" class="auth-link">Zaloguj</a>
        <a href="register.php" class="auth-link">Zarejestruj</a>
    </div>
    <nav class="main-nav">
        <a href="html_poradnia.php" class="nav-link">Strona Główna</a>
        <a href="aktualnosci.php" class="nav-link">Aktualności</a>
        <a href="o_lekarzu.php" class="nav-link">Informacje o Lekarzu</a>
        <a href="kontakt.php" class="nav-link">Kontakt</a>
    </nav>
    <h1>Aktualności Poradni Lekarskiej</h1>
</header>

<div class="news-container">
    <article class="news-item">
        <h2>Zmiana godzin przyjęć</h2>
        <p>Uprzejmie informujemy, że od dnia 15 maja zmieniają się godziny przyjęć w naszej poradni. Nowe godziny to 8:00 - 16:00 od poniedziałku do piątku.</p>
        <p>Data publikacji: 14-05-2024</p>
    </article>
    <article class="news-item">
        <h2>Nowy specjalista w naszym zespole</h2>
        <p>Z przyjemnością informujemy, że do naszego zespołu dołączył nowy specjalista kardiologii, dr Adam Kowalski. Dr Kowalski będzie przyjmował pacjentów od czerwca.</p>
        <p>Data publikacji: 10-05-2024</p>
    </article>
    <article class="news-item">
        <h2>Bezpłatne badania przesiewowe</h2>
        <p>Informujemy, że w dniach 20-25 maja przeprowadzamy bezpłatne badania przesiewowe w kierunku cukrzycy. Zapraszamy do zapisów przez naszą stronę internetową lub telefonicznie.</p>
        <p>Data publikacji: 05-05-2024</p>
    </article>
</div>
<footer>
    <p class="footer-text">© 2024 MediCor Krzysztof Wronisz</p>
</footer>
</body>
</html>