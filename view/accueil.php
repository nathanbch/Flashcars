<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure les fichiers nécessaires
include_once 'config.php'; // Fichier de configuration pour la base de données


// Affichage de la page d'accueil
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<header>
        <nav class="navbar">
            <h1>FLASHCARS</h1>
            <?php if (isset($_SESSION['username'])) : ?>
                <p>
                    Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> |
                    <a href="index.php?page=deconnexion">Déconnexion</a> |
                </p>
            <?php else : ?>
                <p>
                    <a href="index.php?page=connexion">Connexion</a> | 
                    <a href="index.php?page=inscription">Inscription</a>
                </p>
            <?php endif; ?>
        </nav>
    </header>
<body>
<body>
    <div class="center-container">
        <a href="index.php?page=achat" class="center-btn">Acheter une voiture</a>
    </div>
</body>

</body>
</html>