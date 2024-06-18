<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt - Poradnia Kardiologiczna</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<main class="contact-layout">
    <section class="contact-info">
        <h2>Kontakt</h2>
        <table>
            <tr>
                <td><strong>Adres:</strong></td>
                <td>ul. Traugutta 7, 11-400 Kętrzyn</td>
            </tr>
            <tr>
                <td><strong>Telefon:</strong></td>
                <td>+48 89 752 27 03</td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td>kontakt@poradnia-kardiologiczna.pl</td>
            </tr>
        </table>
    </section>
    <section class="contact-form">
        <h2>Formularz Kontaktowy</h2>
        <form action="" method="post">
            <label for="name">Imię:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="surname">Nazwisko:</label>
            <input type="text" id="surname" name="surname" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="message">Wiadomość:</label><br>
            <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>

            <button type="submit">Wyślij</button>
        </form>

        <?php
        // Połączenie z bazą danych
        $db = new mysqli("localhost", "Wojtek", "123", "Pacjenci");

        // Sprawdzenie połączenia z bazą danych
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Obsługa formularza po jego przesłaniu
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Pobranie danych z formularza
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            // Zabezpieczenie przed SQL Injection (przy użyciu prepared statements)
            $query = "INSERT INTO formularz (imie, nazwisko, email, wiadomosc, data_wyslania) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $db->prepare($query);

            // Przypisanie wartości i wykonanie zapytania
            $stmt->bind_param("ssss", $name, $surname, $email, $message);
            $stmt->execute();

            // Sprawdzenie czy zapytanie się powiodło
            if ($stmt->affected_rows > 0) {
                echo "<p class='success'>Dane zostały pomyślnie zapisane.</p>";
            } else {
                echo "<p class='error'>Wystąpił błąd podczas zapisywania danych.</p>";
            }

            // Zamknięcie zapytania
            $stmt->close();
        }

        // Zamknięcie połączenia z bazą danych
        $db->close();
        ?>
    </section>
    <section class="contact-map">
        <h2>Lokalizacja</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d585.2150844117845!2d21.3765775!3d54.07622009999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46e23a5988a021bb%3A0x6e5b01b361d6d1c3!2sNZOZ%20Medicor%20Krzysztof%20Wronisz!5e0!3m2!1spl!2spl!4v1718650128665!5m2!1spl!2spl" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
