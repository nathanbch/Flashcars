<?php
// Démarrage de la session
session_start();

// Inclusion de la configuration de la base de données
require 'config.php';

try {
    // Requête pour récupérer les véhicules disponibles
    $query = "SELECT * FROM Voiture WHERE Statut = 'Disponible'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $voitures = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des véhicules : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Véhicules</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <h1>FLASHCARS</h1>
            <?php if (isset($_SESSION['username'])) : ?>
                <p>
                    Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> |
                    <a href="logout.php">Déconnexion</a>
                </p>
            <?php else : ?>
                <p>
                    <a href="login.php">Connexion</a> | 
                    <a href="register.php">Inscription</a>
                </p>
            <?php endif; ?>
        </nav>
    </header>
    <main class="container">
        <h2>Véhicules disponibles</h2>
        <div class="car-grid">
            <?php foreach ($voitures as $voiture): ?>
                <div class="car-card">
                    <?php if (!empty($vehicule['Photo'])): ?>
                        <img src="<?php echo htmlspecialchars($vehicule['Photo']); ?>" alt="Photo de <?php echo htmlspecialchars($vehicule['Marque'] . ' ' . $vehicule['Modele']); ?>">
                    <?php else: ?>
                        <img src="placeholder.jpg" alt="Image non disponible">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($vehicule['Marque'] . ' ' . $vehicule['Modele']); ?></h3>
                    <p><strong>Année :</strong> <?php echo htmlspecialchars($vehicule['Annee']); ?></p>
                    <p><strong>Prix :</strong> <?php echo number_format($vehicule['Prix'], 2); ?> €</p>
                    <p><strong>Quantité disponible :</strong> <?php echo htmlspecialchars($vehicule['Quantite']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
