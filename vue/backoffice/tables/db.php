<?php
$host = 'localhost';  // Adresse de l'hôte de la base de données
$dbname = 'login';    // Nom de votre base de données
$username = 'root';   // Nom d'utilisateur pour la base de données
$password = '';       // Mot de passe pour la base de données

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configuration pour gérer les erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
