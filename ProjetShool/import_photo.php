<?php
$title = "Importer et Éditer une Photo";
ob_start();
require 'db.php';

// Récupérer la liste des écoles
$ecoles = $pdo->query("SELECT * FROM ecoles")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importer une Photo</title>
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
        input, select, button {
            margin: 10px;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>


<form method="POST" action="save_photo.php" enctype="multipart/form-data">
    <label>École :</label>
    <select name="school" required>
        <option value="">-- Sélectionner une école --</option>
        <?php foreach ($ecoles as $ecole): ?>
            <option value="<?php echo $ecole['id']; ?>"><?php echo $ecole['nom']; ?></option>
        <?php endforeach; ?>
    </select>

    <label>Classe :</label>
    <select name="class" required>
        <option value="">-- Sélectionner une classe --</option>
    </select>

    <input type="text" name="firstname" placeholder="Prénom de l'élève" required>
    <input type="text" name="lastname" placeholder="Nom de l'élève" required>

    <label>Importer une Photo :</label>
    <input type="file" name="imported_photo" accept="image/*" required>

    <button type="submit">Enregistrer la Photo</button>

    <div class="mt-4">
        <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
    </div>
</form>

<script>
    const schoolSelect = document.querySelector('select[name="school"]');
    const classSelect = document.querySelector('select[name="class"]');

    // Charger dynamiquement les classes selon l'école sélectionnée
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
$content = ob_get_clean();
include 'template.php';
?>
