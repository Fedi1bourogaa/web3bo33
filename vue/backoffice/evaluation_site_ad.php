<?php
// Inclure la configuration pour la connexion à la base de données
include '../../config.php';

// Démarrer la session et vérifier que l'utilisateur est un administrateur
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo "Vous devez être administrateur pour accéder à cette page.";
    exit();
}

$pdo = config::getConnexion(); // Connexion à la base de données

// Récupérer toutes les évaluations des utilisateurs
$query = $pdo->query("SELECT u.nom, se.interface_rating, se.performance_rating, se.content_rating, se.general_comment, se.created_at 
                      FROM evaluations se 
                      JOIN users u ON se.user_id = u.id");
$evaluations = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Évaluations</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
      body {
    font-family: 'Poppins', sans-serif;
    background-image: url('evaluationtest.jpeg'); /* Remplacez par le chemin de votre image */
    background-size: cover; /* L'image couvre toute la zone */
    background-position: center center; /* L'image est centrée */
    background-repeat: no-repeat; /* L'image ne se répète pas */
    color: #333;
    margin: 0;
    padding: 0;
}

h2 {
    text-align: center;
    margin-top: 40px;
    color: #c0392b;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 30px;
    background-color: rgba(255, 255, 255, 0.8); /* Fond blanc légèrement transparent */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: center;
}

th {
    background-color: #e74c3c;
    color: white;
}

td {
    background-color: rgba(249, 249, 249, 0.9); /* Fond des cellules légèrement transparent */
}

.rating {
    font-size: 1.5rem;
}

.emoji {
    margin-right: 10px;
}

    </style>
</head>
<body>

    <h2>Gestion des évaluations des utilisateurs</h2>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Nom de l'utilisateur</th>
                    <th>Interface utilisateur</th>
                    <th>Performance du site</th>
                    <th>Qualité du contenu</th>
                    <th>Commentaire général</th>
                    <th>Date de l'évaluation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evaluations as $evaluation): ?>
                    <tr>
                        <td><?= htmlspecialchars($evaluation['nom']) ?></td>
                        <td class="rating">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo ($evaluation['interface_rating'] == $i) ? "★" : "☆";
                            }
                            ?>
                        </td>
                        <td class="rating">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo ($evaluation['performance_rating'] == $i) ? "★" : "☆";
                            }
                            ?>
                        </td>
                        <td class="rating">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo ($evaluation['content_rating'] == $i) ? "★" : "☆";
                            }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($evaluation['general_comment']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($evaluation['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
