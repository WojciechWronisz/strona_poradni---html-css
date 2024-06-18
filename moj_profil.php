<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
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
        // Przykładowa historia wizyt (może być pobierana z bazy danych lub innych źródeł danych)
        $visits = array(
            array('date' => '2023-05-15', 'description' => 'Konsultacja rutynowa', 'recommendation' => 'Regularne badania kontrolne.'),
            array('date' => '2023-07-28', 'description' => 'Badanie EKG', 'recommendation' => 'Zmiana diety i regularne ćwiczenia fizyczne.'),
        );

        if ($userLoggedIn) {
            echo '<ul>';
            foreach ($visits as $visit) {
                echo '<li>';
                echo 'Data: ' . htmlspecialchars($visit['date']) . ', ';
                echo 'Opis: ' . htmlspecialchars($visit['description']) . ', ';
                echo 'Zalecenia: ' . htmlspecialchars($visit['recommendation']);
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Proszę się zalogować, aby zobaczyć historię wizyt.</p>';
        }
        ?>
    </div>

    <h1>Zarządzanie danymi osobowymi</h1>
    <?php if ($userLoggedIn) : ?>
        <form action="update-profile.php" method="post">
            <label for="address">Adres:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($userAddress); ?>"><br><br>

            <label for="phone">Numer telefonu:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($userPhone); ?>"><br><br>

            <button type="submit">Zapisz zmiany</button>
        </form>
    <?php else : ?>
        <p>Proszę się zalogować, aby zarządzać danymi osobowymi.</p>
    <?php endif; ?>
</main>
</body>
</html>

<?php include 'footer.php'; ?>
