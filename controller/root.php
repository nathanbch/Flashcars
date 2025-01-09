<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
    case 'accueil':
        include 'view/accueil.php';
        break;
    case 'inscription':
        include 'view/register.php';
        break;

    case 'connexion':
        include 'view/login.php';
        break;

    case 'deconnexion':
        include 'view/logout.php';
        break;

    case 'achat':
        include 'view/affichage_vehicules.php';
        break;

    default:
        include 'view/404.php';
}
?>