<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? "Page"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            background-color: #198754;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 15px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Menu latéral -->
    <div class="sidebar">
        <h4 class="text-center text-light">Gestion Scolaire</h4>
        <a href="index.php">Accueil</a>
        <a href="take_photo.php">Prendre une Photo</a>
        <a href="list_photos.php">Voir Photos</a>
        <a href="manage_schools.php">Gérer Écoles et Classes</a>
        <a href="import_photo.php">Importer photo</a>

        
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <div class="container-fluid">
            <h1 class="mt-4"><?php echo $title ?? "Titre de la Page"; ?></h1>
            <?php echo $content ?? "Contenu de la page"; ?>
        </div>
    </div>

</body>
</html>
