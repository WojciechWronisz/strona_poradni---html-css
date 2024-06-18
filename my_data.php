<?php
session_start();

// Połączenie z bazą danych
$db = new mysqli("localhost", "Wojtek", "123", "Pacjenci");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Sprawdzenie czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: register.php"); // Przekierowanie do register.php w przypadku braku zalogowania
    exit();
}

$user_id = $_SESSION['user_id'];

// Pobranie aktualnych danych użytkownika
$q = $db->prepare("SELECT Imię, Nazwisko, PESEL, Numer_Telefonu, Miejscowość, Adres, Email FROM pacjenci WHERE Indeks = ?");
$q->bind_param("i", $user_id);
$q->execute();
$result = $q->get_result();
$user = $result->fetch_assoc();
$q->close();

// Obsługa aktualizacji danych użytkownika
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $pesel = $_POST['pesel'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Jeśli hasło zostało zmienione, zaktualizuj w bazie danych
    if (!empty($password)) {
        $passwordHash = password_hash($password, PASSWORD_ARGON2I);
        $q = $db->prepare("UPDATE pacjenci SET Imię = ?, Nazwisko = ?, PESEL = ?, Numer_Telefonu = ?, Miejscowość = ?, Adres = ?, Email = ?, Hasło = ? WHERE Indeks = ?");
        $q->bind_param("ssssssssi", $firstname, $lastname, $pesel, $phone, $city, $address, $email, $passwordHash, $user_id);
    } else {
        // Jeśli hasło nie zostało zmienione, zaktualizuj bez zmiany hasła
        $q = $db->prepare("UPDATE pacjenci SET Imię = ?, Nazwisko = ?, PESEL = ?, Numer_Telefonu = ?, Miejscowość = ?, Adres = ?, Email = ? WHERE Indeks = ?");
        $q->bind_param("sssssssi", $firstname, $lastname, $pesel, $phone, $city, $address, $email, $user_id);
    }

    if ($q->execute()) {
        $_SESSION['user_email'] = $email; // Zaktualizowanie adresu e-mail w sesji, jeśli został zmieniony
        $_SESSION['success_message'] = "Dane konta zostały zaktualizowane.";
        // Aktualizacja danych wyświetlanych na stronie
        $user['Imię'] = $firstname;
        $user['Nazwisko'] = $lastname;
        $user['PESEL'] = $pesel;
        $user['Numer_Telefonu'] = $phone;
        $user['Miejscowość'] = $city;
        $user['Adres'] = $address;
        $user['Email'] = $email;
    } else {
        $_SESSION['error_message'] = "Wystąpił błąd podczas aktualizacji danych.";
    }

    $q->close();
}

$db->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje Konto - Panel Pacjenta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<main class="container">
    <h1>Moje Konto</h1>

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

    <form action="my_data.php" method="post">
        <label for="firstname">Imię:</label>
        <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['Imię']); ?>" required>
        <label for="lastname">Nazwisko:</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['Nazwisko']); ?>" required>
        <label for="pesel">PESEL:</label>
        <input type="text" id="pesel" name="pesel" value="<?php echo htmlspecialchars($user['PESEL']); ?>" required>
        <label for="phone">Numer Telefonu:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['Numer_Telefonu']); ?>" required>
        <label for="city">Miejscowość:</label>
        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['Miejscowość']); ?>" required>
        <label for="address">Adres:</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['Adres']); ?>" required>
        <label for="email">Adres Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
        <label for="password">Hasło (pozostaw puste, aby nie zmieniać):</label>
        <input type="password" id="password" name="password">
        <button type="submit">Zaktualizuj dane</button>
    </form>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
