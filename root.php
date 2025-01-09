<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
    case 'accueil':
        if (file_exists('index.php')) {
            include 'index.php';
        } else {
            echo "Erreur : page d'accueil indisponible.";
        }
        break;

    case 'inscription':
        if (file_exists('register.php')) {
            include 'register.php';
        } else {
            echo "Erreur : page d'inscription indisponible.";
        }
        break;

    case 'connexion':
        if (file_exists('login.php')) {
            include 'login.php';
        } else {
            echo "Erreur : page de connexion indisponible.";
        }
        break;

    case 'deconnexion':
        if (file_exists('logout.php')) {
            include 'logout.php';
        } else {
            echo "Erreur : page de déconnexion indisponible.";
        }
        break;

    case 'panier':
        if (file_exists('achat.php')) {
            include 'achat.php';
        } else {
            echo "Erreur : page de panier indisponible.";
        }
        break;

    default:
        if (file_exists('404.php')) {
            include '404.php';
        } else {
            echo "Erreur 404 : page non trouvée.";
        }
        break;
}
?>