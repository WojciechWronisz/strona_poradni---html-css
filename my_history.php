<?php
include 'header.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Przegląd historii wizyt u kardiologa</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<main>
    <h1>Przegląd historii wizyt u kardiologa</h1>
    <div class="visit-history">
        <?php
        if (isset($_SESSION['user_id'])) {
            $user_email = $_SESSION['user_id']; // Przyjmuję, że $_SESSION['user_id'] przechowuje adres e-mail użytkownika

            // Połączenie z bazą danych
            $db = new mysqli("localhost", "Wojtek", "123", "Pacjenci");
            if ($db->connect_error) {
                die("Connection failed: " . $db->connect_error);
            }

            // Pobranie id pacjenta na podstawie adresu e-mail użytkownika
            $stmt = $db->prepare("SELECT Indeks FROM pacjenci WHERE Email = ?");
            $stmt->bind_param("s", $user_email);
            $stmt->execute();
            $stmt->bind_result($id_pacjenta);
            $stmt->fetch();
            $stmt->close();

            // Pobranie historii wizyt użytkownika na podstawie jego id_pacjenta
            if (isset($id_pacjenta)) {
                $stmt_visits = $db->prepare("SELECT data, opis, zalecenia FROM historia_wizyt WHERE id_pacjenta = ?");
                $stmt_visits->bind_param("i", $id_pacjenta);
                $stmt_visits->execute();
                $result = $stmt_visits->get_result();

                if ($result->num_rows > 0) {
                    echo '<h2>Twoja historia wizyt:</h2>';
                    echo '<ul>';
                    while ($row = $result->fetch_assoc()) {
                        echo '<li>';
                        echo 'Data: ' . htmlspecialchars($row['data']) . ', ';
                        echo 'Opis: ' . htmlspecialchars($row['opis']) . ', ';
                        echo 'Zalecenia: ' . htmlspecialchars($row['zalecenia']);
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p>Brak wpisów w historii wizyt.</p>';
                }

                $stmt_visits->close();
            } else {
                echo '<p class="error">Nie znaleziono id pacjenta dla zalogowanego użytkownika.</p>';
            }

            $db->close();
        } else {
            echo '<p>Proszę się zalogować, aby zobaczyć historię wizyt.</p>';
        }
        ?>
    </div>

</main>
</body>
</html>

<?php include 'footer.php'; ?>
