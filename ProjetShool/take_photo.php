<?php
$title = "Gérer Écoles";
ob_start(); // Démarre la capture du contenu
require 'db.php';

// Récupérer toutes les écoles
$ecoles = $pdo->query("SELECT * FROM ecoles")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Photo École</title>
 <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            background-image: url('/PROJETSHOOL/images/schools.png');
            background-size: cover; /* Pour couvrir toute la zone */
            background-position: center; /* Position centrale */
            background-repeat: no-repeat; /* Pas de répétition */
            background-attachment: fixed; /* Pour fixer l'image */
        }
        video, canvas {
            display: block;
            margin: 10px auto;
            max-width: 80%;
            border: 2px solid black;
        }
        button, input, select {
            padding: 10px;
            font-size: 16px;
            mar   gin-top: 10px;
            
        }
    </style>
</head>
<body>

    <h1>Prise de Photo - Application École</h1>

    <form method="POST" action="save_photo.php">
        <label>École :</label>
        <select name="school" id="school" required>
            <option value="">-- Sélectionner une école --</option>
            <?php foreach ($ecoles as $ecole): ?>
                <option value="<?php echo $ecole['id']; ?>"><?php echo $ecole['nom']; ?></option>
            <?php endforeach; ?>
        </select>

        <label>Classe :</label>
        <select name="class" id="class" required>
            <option value="">-- Sélectionner une classe --</option>
        </select>

        <input type="text" name="firstname" placeholder="Prénom de l'élève" required>
        <input type="text" name="lastname" placeholder="Nom de l'élève" required>

        <video id="video" autoplay></video>
        <canvas id="canvas" style="display: none;"></canvas>
        <button type="button" id="snap">Prendre une Photo</button>  <label>

        <input type="hidden" id="photo_data" name="photo_data">

        <button type="submit">Enregistrer la Photo</button>


        <div class="mt-4">
            <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
        </div>
    </form>

    <script src="js/script.js"></script>
    <script>
        const schoolSelect = document.getElementById('school');
        const classSelect = document.getElementById('class');

        // Charger dynamiquement les classes selon l'école choisie
        schoolSelect.addEventListener('change', async function () {
            const schoolId = this.value;
            classSelect.innerHTML = '<option value="">-- Sélectionner une classe --</option>';

            if (schoolId) {
                const response = await fetch(`get_classes.php?school_id=${schoolId}`);
                const classes = await response.json();

                classes.forEach(classe => {
                    const option = document.createElement('option');
                    option.value = classe.id;
                    option.textContent = classe.nom;
                    classSelect.appendChild(option);
                });
            }
        });
    </script>

</body>
</html>
<?php
$content = ob_get_clean(); // Capture le contenu
include 'template.php'; // Inclut le template avec le contenu capturé
?>

