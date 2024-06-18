<?php
$db = new mysqli('localhost', 'Wojtek', '123', 'Pacjenci');
$db = new mysqli('localhost', 'Wojtek', '123', 'Users');

// Sprawdzanie połączenia
if ($db->connect_error) {
    die('Błąd połączenia z bazą danych: ' . $db->connect_error);
}
?>
