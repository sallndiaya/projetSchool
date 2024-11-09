<?php
$title = "Gérer Écoles";
ob_start();
require 'db.php';

if (isset($_POST['school'], $_POST['class'], $_POST['firstname'], $_POST['lastname'])) {
    $school_id = (int)$_POST['school'];
    $class_id = (int)$_POST['class'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    // Récupérer le nom de l'école et de la classe
    $school = $pdo->query("SELECT nom FROM ecoles WHERE id = $school_id")->fetchColumn();
    $class = $pdo->query("SELECT nom FROM classes WHERE id = $class_id")->fetchColumn();

    // Création du répertoire de destination
    $directory = "uploads/$school/$class";
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    // Enregistrement de la photo
    $file_name = 'photo_' . time();
    $photo_path = '';

    if (!empty($_POST['photo_data'])) {
        // Prise de photo avec la caméra
        $data = $_POST['photo_data'];
        $image_parts = explode(";base64,", $data);
        $image_base64 = base64_decode($image_parts[1]);
        $photo_path = "$directory/{$file_name}.png";
        file_put_contents($photo_path, $image_base64);
    } elseif (!empty($_FILES['imported_photo']['name'])) {
        // Importation de photo depuis un fichier
        $extension = pathinfo($_FILES['imported_photo']['name'], PATHINFO_EXTENSION);
        $photo_path = "$directory/{$file_name}.$extension";
        move_uploaded_file($_FILES['imported_photo']['tmp_name'], $photo_path);
    } else {
        echo "Aucune photo fournie.";
        exit;
    }

    // Enregistrement des informations de l'élève dans un fichier JSON
    $info = ['firstname' => $firstname, 'lastname' => $lastname, 'photo' => basename($photo_path)];
    $json_file = "$directory/data.json";
    $existing_data = file_exists($json_file) ? json_decode(file_get_contents($json_file), true) : [];
    $existing_data[] = $info;
    file_put_contents($json_file, json_encode($existing_data));

    echo "Photo et informations enregistrées avec succès.";
} else {
    echo "Données incomplètes.";
}
?>
