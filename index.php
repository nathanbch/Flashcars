<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure les fichiers nécessaires
include_once 'config.php'; // Fichier de configuration pour la base de données
// Test de connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=flashcarsbdd", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

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
            <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> | <a href="logout.php">Déconnexion</a></p>
        <?php else : ?>
            <p><a href="login.php">Connexion</a> | <a href="register.php">Inscription</a></p>
        <?php endif; ?>
    </nav>
</header>
<body>
</body>
</html>