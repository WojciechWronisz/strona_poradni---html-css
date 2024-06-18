<?php include 'header.php'; ?>

<main>
    <h1>Galeria</h1>
    <div class="gallery">
        <img src="photos /image000001.jpeg" alt="Gabinet">
        <img src="photos /image000002.jpeg" alt="Wejście">
    </div>

    <h1>Cennik</h1>
    <table class="price-list">
        <thead>
        <tr>
            <th>Usługa</th>
            <th>Cena</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Podstawowa wizyta</td>
            <td>150 zł</td>
        </tr>
        <tr>
            <td>Konsultacja specjalistyczna</td>
            <td>250 zł</td>
        </tr>
        <tr>
            <td>Badanie diagnostyczne</td>
            <td>350 zł</td>
        </tr>
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
    // Tablica usług do filtrowania
    $services = array(
        array('usluga' => 'Podstawowa wizyta', 'cena' => '150 zł'),
        array('usluga' => 'Konsultacja specjalistyczna', 'cena' => '250 zł'),
        array('usluga' => 'Badanie diagnostyczne', 'cena' => '350 zł')
    );

    // Pobierz wybór użytkownika z formularza
    if (isset($_GET['price-filter'])) {
        $filter = $_GET['price-filter'];

        // Przetwarzaj filtrowanie na podstawie wyboru użytkownika
        switch ($filter) {
            case 'below-200':
                $filteredServices = array_filter($services, function ($service) {
                    $price = intval(str_replace([' ', 'zł'], '', $service['cena']));
                    return $price < 200;
                });
                break;
            case '200-300':
                $filteredServices = array_filter($services, function ($service) {
                    $price = intval(str_replace([' ', 'zł'], '', $service['cena']));
                    return $price >= 200 && $price <= 300;
                });
                break;
            case 'above-300':
                $filteredServices = array_filter($services, function ($service) {
                    $price = intval(str_replace([' ', 'zł'], '', $service['cena']));
                    return $price > 300;
                });
                break;
            case 'all':
            default:
                $filteredServices = $services;
                break;
        }

        // Wyświetlenie wyników filtrowania jako HTML
        echo '<h2>Wyniki filtracji:</h2>';
        echo '<table class="price-list">';
        echo '<thead><tr><th>Usługa</th><th>Cena</th></tr></thead>';
        echo '<tbody>';
        foreach ($filteredServices as $service) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($service['usluga']) . '</td>';
            echo '<td>' . htmlspecialchars($service['cena']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }
    ?>

</main>

<?php include 'footer.php'; ?>
