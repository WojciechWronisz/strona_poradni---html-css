<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kontakt - Poradnia Kardiologiczna</title>
  <link rel="stylesheet" href="css_kontakt.css">
  <script>
    function goBack() {
      window.history.back();
    }
  </script>
</head>
<body>
<header id="main-header">
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
  <h1>Strona Kontaktowa Poradni Lekarskiej</h1>
</header>
<main>
  <section class="contact-info">
    <h2>Kontakt</h2>
    <p>Jeżeli masz pytania lub chcesz umówić się na wizytę, skontaktuj się z nami:</p>
    <ul>
      <li><strong>Adres:</strong> ul. Zdrowa 10, 80-100 Gdańsk</li>
      <li><strong>Telefon:</strong> +48 123 456 789</li>
      <li><strong>Email:</strong> kontakt@poradnia-kardiologiczna.pl</li>
    </ul>
  </section>
  <section class="contact-form">
    <h2>Formularz Kontaktowy</h2>
    <form action="submit_form.php" method="post">
      <label for="name">Imię i nazwisko:</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="message">Wiadomość:</label>
      <textarea id="message" name="message" required></textarea>

      <button type="submit">Wyślij</button>
    </form>
  </section>
  <button onclick="goBack()" class="back-button">Powrót</button>
</main>
<footer>
  <p class="footer-text">© 2024 MediCor Krzysztof Wronisz</p>
</footer>
</body>
</html>
