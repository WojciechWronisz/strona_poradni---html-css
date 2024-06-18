<?php
session_start();
include 'header.php';

// Enable error reporting (for development, disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$db = new mysqli("localhost", "Wojtek", "123", "Pacjenci");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == "login") {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $stmt = $db->prepare("SELECT * FROM pacjenci WHERE Email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $userRow = $result->fetch_assoc();

        if ($userRow && password_verify($password, $userRow['Hasło'])) {
            session_regenerate_id(true); // Prevent session fixation
            $_SESSION['user_id'] = $userRow['Indeks'];
            $_SESSION['user_email'] = $userRow['Email'];
            header("Location: moj_profil.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Błędny login lub hasło";
            header("Location: register.php");
            exit();
        }

    } elseif ($action == "register") {
        $imie = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $nazwisko = filter_var($_POST['surname'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $passwordRepeat = $_POST['passwordRepeat'];

        if ($password !== $passwordRepeat) {
            $_SESSION['error_message'] = "Hasła nie są zgodne!";
            header("Location: register.php");
            exit();
        }

        $stmt = $db->prepare("SELECT Email FROM pacjenci WHERE Email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['error_message'] = "Konto z tym adresem email już istnieje!";
            $stmt->close();
            header("Location: register.php");
            exit();
        }

        $stmt->close();

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO pacjenci (Imię, Nazwisko, PESEL, Numer_Telefonu, Miejscowość, Adres Email, Hasło) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $imie, $nazwisko, $email, $passwordHash);

        if ($stmt->execute()) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['success_message'] = "Konto utworzono poprawnie!";
            header("Location: moj_profil.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Coś poszło nie tak: " . $stmt->error;
            header("Location: register.php");
            exit();
        }

        $stmt->close();
    } elseif ($action == "logout") {
        session_destroy();
        header("Location: register.php");
        exit();
    }
}

$db->close();
?>

<main>
    <div class="auth-container">
        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }
        ?>
        <div id="login" class="auth-form">
            <form action="register.php" method="post">
                <h2>Logowanie</h2>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
                <input type="hidden" name="action" value="login">
                <button type="submit">Zaloguj się</button>
            </form>
        </div>
        <div id="register" class="auth-form">
            <form action="register.php" method="post">
                <h2>Rejestracja</h2>
                <label for="name">Imię:</label>
                <input type="text" id="name" name="name" required>
                <label for="surname">Nazwisko:</label>
                <input type="text" id="surname" name="surname" required>
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
</main>

<?php include 'footer.php'; ?>
