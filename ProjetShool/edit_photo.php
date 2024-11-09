<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $photo = $_POST['photo'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    $directory = "uploads/Ecole1/ClasseA"; // Modifier selon votre structure
    $filepath = "$directory/$photo";

    if (file_exists($filepath)) {
        $image = imagecreatefrompng($filepath); // Pour une image PNG
        $black = imagecolorallocate($image, 0, 0, 0);
        $font = __DIR__ . '/arial.ttf'; // Assurez-vous que la police est disponible

        $text = "$firstname $lastname";
        $font_size = 20;

        // Calculer les coordonnées pour centrer le texte
        $bbox = imagettfbbox($font_size, 0, $font, $text);
        $x = (imagesx($image) - $bbox[2]) / 2;
        $y = imagesy($image) - 30;

        // Ajouter le texte à l'image
        imagettftext($image, $font_size, 0, $x, $y, $black, $font, $text);

        // Enregistrer l'image modifiée
        imagepng($image, $filepath);
        imagedestroy($image);

        echo "Photo éditée avec succès.";
    } else {
        echo "La photo n'existe pas.";
    }
}
?>
