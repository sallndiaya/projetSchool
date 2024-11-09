<?php
$title = "Gérer Écoles";
ob_start(); // Démarre la capture du contenu
require 'db.php'; // Connexion à la base de données

// Ajout d'une école
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_school'])) {
    $schoolName = $_POST['school_name'];
    $stmt = $pdo->prepare("INSERT INTO ecoles (nom) VALUES (?)");
    $stmt->execute([$schoolName]);
    header('Location: manage_schools.php');
    exit;
}

// Ajout d'une classe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_class'])) {
    $className = $_POST['class_name'];
    $schoolId = $_POST['school_id'];
    $stmt = $pdo->prepare("INSERT INTO classes (nom, ecole_id) VALUES (?, ?)");
    $stmt->execute([$className, $schoolId]);
    header('Location: manage_schools.php');
    exit;
}

// Récupération des écoles et classes
$schools = $pdo->query("SELECT * FROM ecoles")->fetchAll(PDO::FETCH_ASSOC);
$classes = $pdo->query("
    SELECT classes.id, classes.nom AS class_name, ecoles.nom AS school_name 
    FROM classes 
    JOIN ecoles ON classes.ecole_id = ecoles.id
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Écoles et Classes</title>
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
        
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Gérer Écoles et Classes</h1>

        <!-- Formulaire pour ajouter une école -->
        <div class="card mb-4">
            <div class="card-header">Ajouter une École</div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="school_name" class="form-label">Nom de l'école</label>
                        <input type="text" class="form-control" id="school_name" name="school_name" required>
                    </div>
                    <button type="submit" name="add_school" class="btn btn-primary">Ajouter École</button>
                </form>
            </div>
        </div>

        <!-- Formulaire pour ajouter une classe -->
        <div class="card mb-4">
            <div class="card-header">Ajouter une Classe</div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="class_name" class="form-label">Nom de la Classe</label>
                        <input type="text" class="form-control" id="class_name" name="class_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="school_id" class="form-label">École</label>
                        <select class="form-select" id="school_id" name="school_id" required>
                            <option value="">Sélectionner une école</option>
                            <?php foreach ($schools as $school): ?>
                                <option value="<?php echo $school['id']; ?>">
                                    <?php echo $school['nom']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="add_class" class="btn btn-success">Ajouter Classe</button>
                </form>
            </div>
        </div>

        <!-- Liste des écoles et classes -->
        <div class="card">
            <div class="card-header">Écoles et Classes</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($schools as $school): ?>
                        <li class="list-group-item">
                            <strong><?php echo $school['nom']; ?></strong>
                            <ul>
                                <?php foreach ($classes as $class): ?>
                                    <?php if ($class['school_name'] === $school['nom']): ?>
                                        <li><?php echo $class['class_name']; ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$content = ob_get_clean(); // Capture le contenu
include 'template.php'; // Inclut le template avec le contenu capturé
?>

