<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die('Proszę się zalogować, aby przesyłać dokumenty.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'documents/';
    $uploadFile = $uploadDir . basename($_FILES['medicalDocument']['name']);

    // Check if the directory exists
    if (!is_dir($uploadDir)) {
        die("Upload directory does not exist.");
    }

    // Check if the file was uploaded without errors
    if ($_FILES['medicalDocument']['error'] != UPLOAD_ERR_OK) {
        die("Error during file upload: " . $_FILES['medicalDocument']['error']);
    }

    // Validate file type and size
    $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'];
    $fileType = mime_content_type($_FILES['medicalDocument']['tmp_name']);
    $maxFileSize = 5000000; // 5MB

    if (!in_array($fileType, $allowedTypes)) {
        die("Invalid file type. Allowed types are: " . implode(', ', $allowedTypes));
    }

    if ($_FILES['medicalDocument']['size'] > $maxFileSize) {
        die("File size exceeds the limit of 5MB.");
    }

    // Move the uploaded file
    if (move_uploaded_file($_FILES['medicalDocument']['tmp_name'], $uploadFile)) {
        echo 'Dokument został pomyślnie przesłany.';
    } else {
        die('Błąd podczas przesyłania pliku. Sprawdź uprawnienia do zapisu w katalogu docelowym.');
    }
} else {
    die("Invalid request method.");
}
?>
