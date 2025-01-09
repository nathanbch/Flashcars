<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            echo "Nom d'utilisateur déjà pris.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            if ($stmt->execute(['username' => $username, 'password' => $hashedPassword])) {
                header('Location: login.php?status=success');
                exit;
            }
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <br>
        <br>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <br>
        <br>
        <button type="submit">S'inscrire</button>
        <a href="index.php">Retour à l'accueil</a>
    </form>
</body>
</html>
