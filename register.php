<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == "login") {
        // Logowanie
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $db = new mysqli("localhost", "root", "", "auth");

        $q = $db->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
        $q->bind_param("s", $email);
        $q->execute();
        $result = $q->get_result();

        $userRow = $result->fetch_assoc();
        if ($userRow == null) {
            // Konto nie istnieje
            echo "Błędny login lub hasło <br>";
        } else {
            // Konto istnieje
            if (password_verify($password, $userRow['passwordHash'])) {
                // Hasło poprawne
                echo "Zalogowano poprawnie <br>";
            } else {
                // Hasło niepoprawne
                echo "Błędny login lub hasło <br>";
            }
        }
    }
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == "register") {
        // Rejestracja nowego użytkownika
        $db = new mysqli("localhost", "root", "", "auth");
        $email = $_REQUEST['email'];

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $password = $_REQUEST['password'];
        $passwordRepeat = $_REQUEST['passwordRepeat'];

        if($password == $passwordRepeat) {
            // Hasła są identyczne - kontynuuj
            $q = $db->prepare("INSERT INTO user VALUES (NULL, ?, ?)");
            $passwordHash = password_hash($password, PASSWORD_ARGON2I);
            $q->bind_param("ss", $email, $passwordHash);
            $result = $q->execute();
            if($result) {
                echo "Konto utworzono poprawnie";
            } else {
                echo "Coś poszło nie tak!";
            }
        } else {
            echo "Hasła nie są zgodne - spróbuj ponownie!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css_logowanie.css">
    <title>Logowanie i Rejestracja</title>
</head>
<body>
<header id="main-header">
    <button onclick="history.back()" class="back-button">Powrót</button>
    <nav class="main-nav">
        <a href="html_poradnia.php" class="nav-link">Strona Główna</a>
        <a href="aktualnosci.php?action=login" class="nav-link">Zaloguj</a>
        <a href="aktualnosci.php?action=register" class="nav-link">Zarejestruj</a>
        <a href="o_lekarzu.php" class="nav-link">Informacje o Lekarzu</a>
        <a href="kontakt.php" class="nav-link">Kontakt</a>
    </nav>
</header>
<main>
    <div class="auth-container">
        <div id="login" class="auth-form">
            <form action="register.php" method="post">
                <h2>Logowanie</h2>
                <label for="username">Nazwa użytkownika lub Email:</label>
                <input type="text" id="username" name="email" required>
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
                <input type="hidden" name="action" value="login">
                <button type="submit">Zaloguj się</button>
            </form>
        </div>
        <div id="register" class="auth-form">
            <form action="register.php" method="post">
                <h2>Rejestracja</h2>
                <label for="login">Nazwa użytkownika:</label>
                <input type="text" id="login" name="login" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
                <label for="passwordRepeat">Powtórz hasło:</label>
                <input type="password" id="passwordRepeat" name="passwordRepeat" required>
                <input type="hidden" name="action" value="register">
                <button type="submit">Zarejestruj się</button>
            </form>
        </div>
    </div>
    <div class="auth-toggle-links">
        <a href="#login" class="auth-link">Zaloguj</a>
        <a href="#register" class="auth-link">Zarejestruj</a>
    </div>
</main>
<footer>
    <p class="footer-text">© 2024 MediCor Krzysztof Wronisz</p>
</footer>
</body>
</html>
