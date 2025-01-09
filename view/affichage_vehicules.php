<?php
// Démarrage de la session
session_start();
include_once 'root.php';

// Connexion à la base de données
require 'config.php';

try {
    // Requête pour récupérer les voitures disponibles
    $query = "SELECT * FROM voiture WHERE Statut = 'Disponible'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $voitures = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des voitures : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<style>
/* Container */
.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Titre */
h2 {
    text-align: center;
    color: #ff6f61;
    margin-bottom: 20px;
}

/* Grille des cartes */
.car-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

/* Cartes de voiture */
.car-card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.car-card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
}

/* Images des cartes */
.car-card img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 15px;
}

/* Informations des cartes */
.car-card h3 {
    font-size: 1.2rem;
    color: #333;
    margin-bottom: 10px;
}

.car-card p {
    font-size: 0.95rem;
    margin: 5px 0;
}

/* Message si aucune voiture disponible */
.container p {
    text-align: center;
    font-size: 1rem;
    color: #666;
}
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voitures Disponibles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <h1>FLASHCARS</h1>
            <?php if (isset($_SESSION['username'])) : ?>
                <p>
                    Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> |
                    <a href="index.php?page=deconnexion">Déconnexion</a> |
                    <a href="index.php?page=accueil">Accueil</a>

                </p>
            <?php else : ?>
                <p>
                    <a href="index.php?page=connexion">Connexion</a> | 
                    <a href="index.php?page=inscription">Inscription</a>
                </p>
            <?php endif; ?>
        </nav>
    </header>
        <main class="container">
    <h2>Voitures Disponibles</h2>
    <?php if (count($voitures) > 0): ?>
        <div class="car-grid">
            <?php foreach ($voitures as $voiture): ?>
                <div class="car-card">
                    <?php if (!empty($voiture['Photo'])): ?>
                        <img src="<?php echo htmlspecialchars($voiture['Photo']); ?>" alt="Photo de <?php echo htmlspecialchars($voiture['Marque'] . ' ' . $voiture['Modele']); ?>">
                    <?php else: ?>
                        <img src="placeholder.jpg" alt="Image non disponible">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($voiture['Marque'] . ' ' . $voiture['Modele']); ?></h3>
                    <p><strong>Année :</strong> <?php echo htmlspecialchars($voiture['Annee']); ?></p>
                    <p><strong>Prix :</strong> <?php echo number_format($voiture['Prix'], 2); ?> €</p>
                    <p><strong>Quantité disponible :</strong> <?php echo htmlspecialchars($voiture['Quantite']); ?></p>
                    <!-- Bouton acheter si l'utilisateur est connecté -->
                    <?php if (isset($_SESSION['username'])): ?>
                        <button onclick="location.href='index.php?page=achat&voiture_id=<?php echo $voiture['id']; ?>'" class="buy-btn">Acheter</button>
                    <?php endif; ?>
                </div>                
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucune voiture disponible pour le moment.</p>
    <?php endif; ?>
    </main>
        </div>
    </main>
</body>
</html>