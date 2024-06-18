<?php
session_start();

// Sprawdzenie czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: register.php"); // Przekierowanie do strony logowania, jeśli użytkownik nie jest zalogowany
    exit();
}

// Obsługa formularza dodawania wyników badań
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobranie danych z formularza
    $data_badania = $_POST['data_badania'];
    $rodzaj_badania = $_POST['rodzaj_badania'];
    $wynik_badania = $_POST['wynik_badania'];

    // Validacja danych (możesz dodać dodatkowe walidacje w zależności od potrzeb)

    // Połączenie z bazą danych
    $db = new mysqli("localhost", "Wojtek", "123", "Pacjenci");
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Pobranie adresu e-mail użytkownika z sesji
    $user_email = $_SESSION['user_id'];

    // Dodanie wyników badań do bazy danych
    $stmt_insert = $db->prepare("INSERT INTO badania (id_pacjenta, data_badania, rodzaj_badania, wynik_badania) VALUES (?, ?, ?, ?)");
    $stmt_insert->bind_param("ssss", $user_email, $data_badania, $rodzaj_badania, $wynik_badania);

    if ($stmt_insert->execute()) {
        $_SESSION['success_message'] = "Wyniki badań zostały dodane.";
    } else {
        $_SESSION['error_message'] = "Błąd podczas dodawania wyników badań: " . $stmt_insert->error;
    }

    $stmt_insert->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje Badania - Panel Pacjenta</title>
    <link rel="stylesheet" href="main.css"> <!-- Stylizacja przy użyciu main.css -->
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
    <h1>Moje Badania</h1>

    <?php
    if (isset($_SESSION['error_message'])) {
        echo "<p class='error'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']);
    }

    if (isset($_SESSION['success_message'])) {
        echo "<p class='success'>" . $_SESSION['success_message'] . "</p>";
        unset($_SESSION['success_message']);
    }
    ?>

    <form action="moje_badania.php" method="post">
        <label for="data_badania">Data badania:</label>
        <input type="date" id="data_badania" name="data_badania" required><br><br>

        <label for="rodzaj_badania">Rodzaj badania:</label>
        <input type="text" id="rodzaj_badania" name="rodzaj_badania" required><br><br>

        <label for="wynik_badania">Wynik badania:</label><br>
        <textarea id="wynik_badania" name="wynik_badania" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">Dodaj wynik badań</button>
    </form>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
