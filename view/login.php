<?php
session_start();
require 'config.php'; // Connexion à la base de données
include_once 'root.php';

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['username'])) {
    echo "Vous êtes déjà connecté ! <a href='index.php?page=deconnexion'>Déconnexion</a>";
    exit();
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Vérification dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        // Vérification du mot de passe
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id']; // Stockage de l'ID dans la session
            header('Location: index.php?page=achat');
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Utilisateur introuvable.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <form method="POST" action="index.php?page=connexion">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <br>
        <br>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <br>
        <br>
        <button type="submit">Se connecter</button>
        <a href="index.php?page=achat">Retour à l'accueil</a>
    </form>
</body>
</html>
