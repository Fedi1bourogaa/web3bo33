<?php
session_start();

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$host = 'localhost';
$dbname = 'login';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer les données de la table "offre"
$sql = "SELECT reference, destination, prix FROM offre";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Offres</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions {
            display: flex;
            justify-content: flex-start;
        }
        .actions a {
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 10px;
        }
        .actions a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Dashboard des Offres</h1>
        
        <!-- Tableau des offres -->
        <table>
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Destination</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($offres as $offre): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($offre['reference']); ?></td>
                        <td><?php echo htmlspecialchars($offre['destination']); ?></td>
                        <td><?php echo htmlspecialchars($offre['prix']); ?> €</td>
                        <td class="actions">
                            <!-- Ajouter des liens ou des boutons pour des actions (modifier/supprimer) -->
                            <a href="modifier_offre.php?reference=<?php echo urlencode($offre['reference']); ?>">Modifier</a>
                            <a href="supprimer_offre.php?reference=<?php echo urlencode($offre['reference']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Ajout d'une nouvelle offre -->
        <div class="actions">
            <a href="ajouter_offre.php">Ajouter une nouvelle offre</a>
        </div>
    </div>

</body>
</html>
