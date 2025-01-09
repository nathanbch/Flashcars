<?php
session_start();
require 'config.php';

try {
    $query = "SELECT * FROM voiture";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $flashcarsbdds = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des voitures : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['voiture_id'])) {
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }

    $voitureId = $_POST['voiture_id'];
    $query = "UPDATE voiture SET stock = stock - 1 WHERE id = :id AND stock > 0";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $voitureId]);

    $_SESSION['cart'][] = $voitureId;

    header('Location: index.php?page=panier');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vente de voitures</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .car-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .car-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .car-card:hover {
            transform: scale(1.05);
        }

        .car-card img {
            max-width: 100%;
            border-radius: 8px;
        }

        .car-name {
            font-size: 1.2rem;
            color: #333;
            margin: 10px 0;
        }

        .car-price {
            font-size: 1.1rem;
            color: #007BFF;
            margin-bottom: 15px;
        }

        .buy-button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
        }

        .buy-button:hover {
            background-color: #0056b3;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Découvrez nos voitures disponibles</h1>
        <div class="car-grid">
                <img src="<?= htmlspecialchars($flashcarsbdd['photo']) ?>">
                <h2><?= htmlspecialchars($flashcarsbdd['marque']) ?> <?=htmlspecialchars($flashcarsbdd['modele'])?></h2>
                <p> <strong> <?= htmlspecialchars($flashcarsbdd['annee'])?> </strong> </p>
                <p><?= htmlspecialchars($flashcarsbdd['description']) ?></p>
                <p><strong>Prix :</strong> <?= number_format($flashcarsbdd['prix'], 2) ?> €</p>
                <p><strong>Catégorie :</strong> <?= htmlspecialchars($flashcarsbdd['categorie']) ?></p>
                <p><strong>Stock :</strong> <?= htmlspecialchars($flashcarsbdd['stock']) ?></p>
                <?php if (isset($_SESSION['user']) && $flashcarsbdd['stock'] > 0): ?>
                    <form method="POST">
                        <input type="hidden" name="manga_id" value="<?= $flashcarsbdd['id'] ?>">
                        <button type="submit" class="btn-acheter">Acheter</button>
                    </form>
                <?php endif; ?>
            </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>