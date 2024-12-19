<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté et si son rôle est "admin"
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Si non, rediriger vers la page de connexion
    exit();
}

// Inclure la configuration pour la connexion à la base de données
include '../../config.php';

// Connexion à la base de données
$pdo = config::getConnexion();

// Récupérer les informations de l'admin depuis la base de données
$userId = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$query->execute([$userId]);
$user = $query->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'admin existe dans la base de données
if (!$user) {
    die("Utilisateur non trouvé.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>
    <style>
        /* Styles généraux pour la page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('tunisia-background.jpg') no-repeat center center fixed;
            background-size: cover; /* L'image prend toute la surface */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Remplir la hauteur de la fenêtre */
            text-align: center;
        }

        /* Conteneur principal du profil */
        .admin-container {
            width: 50%;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9); /* Fond légèrement transparent */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: left; /* Aligner le texte à gauche */
        }

        /* Titre principal */
        h2 {
            color: #b71c1c; /* Couleur rouge pour le titre */
            font-size: 24px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        /* Styles pour chaque information du profil */
        p {
            font-size: 18px;
            margin: 10px 0;
        }

        /* Mettre en évidence les labels (ex. Nom, Prénom, etc.) */
        strong {
            color: #b71c1c;
        }

        /* Liens pour modifier ou se déconnecter */
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #b71c1c;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        /* Effet au survol des liens */
        a:hover {
            background-color: #8e0b0b; /* Change la couleur de fond lors du survol */
        }

        /* Ajout de l'espacement entre les éléments */
        .admin-container p, .admin-container a {
            margin-bottom: 10px;
        }

        /* Styles supplémentaires pour l'effet de fond */
        .admin-container h2, .admin-container p {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h2>Profil de l'Administrateur</h2>
        <p><strong>ID:</strong> <?= htmlspecialchars($user['id']) ?></p>
        <p><strong>Nom:</strong> <?= htmlspecialchars($user['nom']) ?></p>
        <p><strong>Prénom:</strong> <?= htmlspecialchars($user['prenom']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Rôle:</strong> <?= htmlspecialchars($user['role']) ?></p>

        <!-- Formulaire de mise à jour (si nécessaire) -->
        <a href="admin_edit_user.php?id=<?= $user['id'] ?>">Modifier</a>
        <a href="http://localhost/web3bo/vue/frontoffice/logout.php">Se déconnecter</a>
    </div>
</body>
</html>
