<?php
session_start();
session_destroy(); // Supprime toutes les données de la session
header('Location: index.php?page=accueil'); // Redirige vers la page de connexion
exit();
?>