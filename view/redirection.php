<?php
session_start();

// Vérification de la session utilisateur
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include 'root.php';
?>