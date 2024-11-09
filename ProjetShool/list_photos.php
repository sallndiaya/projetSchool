<?php
$title = "Gérer Écoles";
ob_start(); // Démarre la capture du contenu
require 'db.php';

// Récupérer la liste des écoles et classes
$ecoles = $pdo->query("SELECT * FROM ecoles")->fetchAll(PDO::FETCH_ASSOC);
$classes = [];

// Vérifier si une école est sélectionnée
$selectedSchoolId = $_GET['school'] ?? null;
$selectedClassId = $_GET['class'] ?? null;

if ($selectedSchoolId) {
    $stmt = $pdo->prepare("SELECT * FROM classes WHERE ecole_id = ?");
    $stmt->execute([$selectedSchoolId]);
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer les informations des élèves
$students = [];
if ($selectedSchoolId && $selectedClassId) {
    $school = $pdo->query("SELECT nom FROM ecoles WHERE id = $selectedSchoolId")->fetchColumn();
    $className = $pdo->query("SELECT nom FROM classes WHERE id = $selectedClassId")->fetchColumn(); // Utiliser une variable distincte

    $directory = "uploads/" . rawurlencode($school) . "/" . rawurlencode($className) . "/data.json"; // Encoder le nom de classe ici

    if (file_exists($directory)) {
        $students = json_decode(file_get_contents($directory), true);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Photos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            background-image: url('/PROJETSHOOL/images/schools.png');
            background-size: cover; /* Pour couvrir toute la zone */
            background-position: center; /* Position centrale */
            background-repeat: no-repeat; /* Pas de répétition */
            background-attachment: fixed; /* Pour fixer l'image */
            background-color: #f0f0f0;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            background-color: white;
        }
        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

    <h1>Liste des Photos</h1>

    <form method="GET" action="list_photos.php">
        <label>École :</label>
        <select name="school" required onchange="this.form.submit()">
            <option value="">-- Sélectionner une école --</option>
            <?php foreach ($ecoles as $ecole): ?>
                <option value="<?php echo $ecole['id']; ?>" 
                    <?php echo $selectedSchoolId == $ecole['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($ecole['nom']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <?php if ($selectedSchoolId): ?>
            <label>Classe :</label>
            <select name="class" required onchange="this.form.submit()">
                <option value="">-- Sélectionner une classe --</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?php echo $class['id']; ?>" 
                        <?php echo $selectedClassId == $class['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($class['nom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>
    </form>

    <?php if (!empty($students)): ?>
        <div class="grid">
            <?php foreach ($students as $student): ?>
                <div class="card">
                    <?php 
                    // Générer le chemin complet de la photo
                    $photoPath = "uploads/" . rawurlencode($school) . "/" . rawurlencode($className) . "/{$student['photo']}"; // Utiliser le nom de classe correct
                    
                    // Vérifier si la photo existe
                    if (file_exists($photoPath)): 
                    ?>
                        <img src="<?php echo htmlspecialchars($photoPath); ?>" alt="Photo de l'élève">
                    <?php else: ?>
                        <p class="error">Photo introuvable</p>
                    <?php endif; ?>
                    <p><?php echo htmlspecialchars("{$student['firstname']} {$student['lastname']}"); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucune photo trouvée pour cette classe.</p>
    <?php endif; ?>

</body>
</html>
<?php
$content = ob_get_clean(); // Capture le contenu
include 'template.php'; // Inclut le template avec le contenu capturé
?>

