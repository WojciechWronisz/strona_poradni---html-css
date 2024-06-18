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
    <title>Wybór opcji dla użytkownika</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<main>
    <h1>Wybierz jedną z opcji:</h1>
    <div class="options">
        <?php if (isset($_SESSION['user_id'])) : ?>
            <ul>
                <li><a href="my_data.php">Moje dane</a></li>
                <li><a href="my_history.php">Moja historia wizyt</a></li>
                <li><a href="moje_badania.php">Moje badania</a></li>
            </ul>
        <?php else : ?>
            <p>Proszę się zalogować, aby uzyskać dostęp do opcji.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>

<?php include 'footer.php'; ?>
