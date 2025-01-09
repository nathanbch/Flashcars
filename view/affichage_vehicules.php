<?php
// Démarrage de la session
session_start();
include_once 'root.php';

// Connexion à la base de données
require 'config.php';

try {
    // Gestion de l'achat
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $voitureID = intval($_POST['VoitureID']);

        // Vérifier la disponibilité de la voiture
        $sql = "SELECT Quantite FROM voiture WHERE VoitureID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $voitureID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['Quantite'] > 0) {
            // Réduire la quantité
            $sql_update = "UPDATE voiture SET Quantite = Quantite - 1 WHERE VoitureID = ?";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->bindParam(1, $voitureID, PDO::PARAM_INT);

            if ($stmt_update->execute()) {
                echo "<script>alert('Achat réussi ! Stock mis à jour.');</script>";
            } else {
                echo "<script>alert('Erreur lors de la mise à jour du stock.');</script>";
            }
        } else {
            echo "<script>alert('Cette voiture est en rupture de stock.');</script>";
        }
    }

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
    /* Réinitialisation des styles par défaut */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
    line-height: 1.6;
}

/* Styles pour le header */
header {
    background-color: #ff6f61;
    color: white;
    text-align: center;
    padding: 20px 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

header h1 {
    font-size: 2.5rem;
    font-weight: bold;
    margin: 0;
}

/* Styles pour le conteneur principal */
main {
    max-width: 1200px;
    margin: 30px auto;
    padding: 20px;
}

/* Styles pour les listes de véhicules */
.vehicle-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

/* Styles pour les cartes de véhicules */
.vehicle-card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.vehicle-card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
}

.vehicle-card h2 {
    font-size: 1.5rem;
    margin: 15px;
    color: #ff6f61;
    text-align: center;
}

.vehicle-card p {
    font-size: 1rem;
    margin: 10px 15px;
    color: #555;
}

.vehicle-card img {
    width: 100%;
    height: auto;
    border-bottom: 1px solid #ddd;
}

/* Boutons */
form {
    text-align: center;
    margin: 15px;
}

button {
    padding: 10px 20px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"] {
    background-color: #ff6f61;
    color: white;
}

button[type="submit"]:hover {
    background-color: #e85c4d;
}

button[disabled] {
    background-color: #ccc;
    cursor: not-allowed;
}

/* Message d'alerte pour la disponibilité */
p.alert {
    background-color: #ffebcc;
    color: #b85c00;
    padding: 10px 15px;
    border-radius: 5px;
    margin: 20px auto;
    text-align: center;
    max-width: 600px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des Voitures</title>
    <link rel="stylesheet" href="view/style.css"> <!-- Lien vers un fichier CSS -->
</head>
<body>
    <header>
        <h1>Nos Voitures Disponibles</h1>
    </header>
    <main>
        <?php if (!empty($voitures)): ?>
            <div class="vehicle-list">
                <?php foreach ($voitures as $voiture): ?>
                    <div class="vehicle-card">
                        <h2><?= htmlspecialchars($voiture['Marque'] . " " . $voiture['Modele']) ?> (<?= htmlspecialchars($voiture['Annee']) ?>)</h2>
                        <p>Prix : <?= htmlspecialchars($voiture['Prix']) ?> €</p>
                        <p>Quantité en stock : <?= htmlspecialchars($voiture['Quantite']) ?></p>
                        <?php if (!empty($voiture['Photo'])): ?>
                            <img src="<?= htmlspecialchars($voiture['Photo']) ?>" alt="Photo de <?= htmlspecialchars($voiture['Modele']) ?>" />
                        <?php endif; ?>
                        <form method="POST" action="">
                            <input type="hidden" name="VoitureID" value="<?= htmlspecialchars($voiture['VoitureID']) ?>">
                            <?php if ($voiture['Quantite'] > 0): ?>
                                <button type="submit">Acheter</button>
                            <?php else: ?>
                                <button type="button" disabled>Rupture de stock</button>
                            <?php endif; ?>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucune voiture disponible pour le moment.</p>
        <?php endif; ?>
    </main>
</body>
</html>