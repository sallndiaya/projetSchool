<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion des Photos</title>

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
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Barre latérale -->
    <div class="d-flex" id="wrapper">
        <nav id="sidebar" class="bg-success text-white p-3">
            <h3 class="text-center">Mon Centre</h3>
            <ul class="nav flex-column mt-4">
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-white">Accueil</a>
                </li>
                <li class="nav-item">
                    <a href="take_photo.php" class="nav-link text-white">Prendre une Photo</a>
                </li>
                <li class="nav-item">
                    <a href="list_photos.php" class="nav-link text-white">Voir les Photos</a>
                </li>
                <li class="nav-item">
                    <a href="manage_schools.php" class="nav-link text-white">Gérer Écoles & Classes</a>
                </li>

                <li class="nav-item">
                    <a href="import_photo.php"  class="nav-link text-white"> Gérer Photos</a>
                </li>
            </ul>
        </nav>

        <!-- Contenu principal -->
         
        <div id="page-content-wrapper" class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="btn btn-success" id="menu-toggle">☰</button>
                <h4 class="ms-3">Tableau de Bord</h4>
            </nav>

            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Prendre une Photo</h5>
                                <p class="card-text">Capturez des photos via la caméra.</p>
                                <a href="take_photo.php" class="btn btn-primary">Accéder</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Importer des Photos</h5>
                                <p class="card-text">Ajouter des photos enregistrées.</p>
                                <a href="import_photo.php" class="btn btn-success">Importer Photo</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Voir les Photos</h5>
                                <p class="card-text">Consultez les photos enregistrées.</p>
                                <a href="list_photos.php" class="btn btn-success">Voir</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title">Gérer Écoles & Classes</h5>
                                <p class="card-text">Ajouter ou modifier les écoles et classes.</p>
                                <a href="manage_schools.php" class="btn btn-info">Gérer Ecoles et Classes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const wrapper = document.getElementById('wrapper');

        menuToggle.addEventListener('click', () => {
            wrapper.classList.toggle('toggled');
        });
    </script>
    

</body>
</html>
