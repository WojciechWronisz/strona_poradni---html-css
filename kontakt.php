<?php include 'header.php';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kontakt - Poradnia Kardiologiczna</title>
  <link rel="stylesheet" href="main.css">
</head>
<body>
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

</body>
</html>
<?php include 'footer.php';
?>