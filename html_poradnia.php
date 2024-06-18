<?php include 'header.php'; ?>

<main>
    <h1>Galeria</h1>
    <div class="gallery">
        <img src="photos /image000001.jpeg" alt="Gabinet">
        <img src="photos /image000002.jpeg" alt="Wejście">
    </div>

    <?php
    // Połączenie z bazą danych
    $dsn = 'mysql:host=localhost;dbname=Pacjenci;charset=utf8';
    $username = 'Wojtek';
    $password = '123';

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Pobranie danych z tabeli cennik_uslug
        $stmt = $pdo->query('SELECT * FROM cennik_uslug');
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Błąd połączenia z bazą danych: ' . $e->getMessage();
    }
    ?>

    <h1>Cennik</h1>
    <table class="price-list">
        <thead>
        <tr>
            <th>Usługa</th>
            <th>Cena</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($services as $service): ?>
            <tr>
                <td><?= htmlspecialchars($service['usluga']) ?></td>
                <td><?= htmlspecialchars($service['cena']) ?> zł</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <form action="html_poradnia.php" method="get">
        <label for="price-filter">Wybierz przedział cenowy:</label>
        <select name="price-filter" id="price-filter">
            <option value="all">Wszystkie ceny</option>
            <option value="below-200">Poniżej 200 zł</option>
            <option value="200-300">200 zł - 300 zł</option>
            <option value="above-300">Powyżej 300 zł</option>
        </select>
        <button type="submit">Filtruj</button>
    </form>

    <?php
    // Obsługa formularza filtrowania
    if (isset($_GET['price-filter'])) {
        $filter = $_GET['price-filter'];

        // Filtrowanie na podstawie wyboru użytkownika
        switch ($filter) {
            case 'below-200':
                $stmt = $pdo->prepare('SELECT * FROM cennik_uslug WHERE cena < 200');
                break;
            case '200-300':
                $stmt = $pdo->prepare('SELECT * FROM cennik_uslug WHERE cena >= 200 AND cena <= 300');
                break;
            case 'above-300':
                $stmt = $pdo->prepare('SELECT * FROM cennik_uslug WHERE cena > 300');
                break;
            case 'all':
            default:
                $stmt = $pdo->query('SELECT * FROM cennik_uslug');
                break;
        }

        // Wykonaj zapytanie
        $stmt->execute();
        $filteredServices = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Wyświetlenie wyników filtrowania
        echo '<h2>Wyniki filtracji:</h2>';
        echo '<table class="price-list">';
        echo '<thead><tr><th>Usługa</th><th>Cena</th></tr></thead>';
        echo '<tbody>';
        foreach ($filteredServices as $service) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($service['usluga']) . '</td>';
            echo '<td>' . htmlspecialchars($service['cena']) . ' zł</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }
    ?>
</main>

<?php include 'footer.php'; ?>
