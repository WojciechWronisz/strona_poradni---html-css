<?php
session_start();
$user_id = $_SESSION['user_id'];
$db = new mysqli("localhost", "Wojtek", "123", "Pacjenci");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$Imię = $_POST['Imię'];
$Nazwisko = $_POST['Nazwisko'];
$PESEL = $_POST['PESEL'];
$Numer_Telefonu = $_POST['Numer_Telefonu'];
$Miejscowość = $_POST['Miejscowość'];
$Adres = $_POST['Adres'];
$Email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
$Hasło = $_POST['Hasło'];

if (!empty($Hasło)) {
    $passwordHash = password_hash($Hasło, PASSWORD_ARGON2I);
    $stmt = $db->prepare("UPDATE pacjenci SET Imię = ?, Nazwisko = ?, PESEL = ?, Numer_Telefonu = ?, Miejscowość = ?, Adres = ?, Email = ?, Hasło = ? WHERE Id = ?");
    $stmt->bind_param("ssssssssi", $Imię, $Nazwisko, $PESEL, $Numer_Telefonu, $Miejscowość, $Adres, $Email, $passwordHash, $user_id);
} else {
    $stmt = $db->prepare("UPDATE pacjenci SET Imię = ?, Nazwisko = ?, PESEL = ?, Numer_Telefonu = ?, Miejscowość = ?, Adres = ?, Email = ? WHERE Id = ?");
    $stmt->bind_param("sssssssi", $Imię, $Nazwisko, $PESEL, $Numer_Telefonu, $Miejscowość, $Adres, $Email, $user_id);
}

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Dane zostały zaktualizowane.";
} else {
    $_SESSION['error_message'] = "Wystąpił błąd podczas aktualizacji danych.";
}

$stmt->close();
$db->close();
header("Location: moj_profil.php"); // Przekierowanie na stronę z kontem użytkownika
exit();
?>
