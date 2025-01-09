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
