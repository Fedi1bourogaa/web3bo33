<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'elhadhra'; // Remplacez par le nom de votre base
$username = 'root'; // Remplacez par votre utilisateur
$password = ''; // Remplacez par votre mot de passe

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer les données de la table "guides"
$sql = "SELECT * FROM guides ORDER BY submitted_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$candidatures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard des Guides</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Candidature des Guides</h1>
    <?php if (isset($_GET['message'])): ?>
        <p><?php echo htmlspecialchars($_GET['message'] === 'accepted' ? 'Candidat accepté et ajouté à la table des guides.' : 'Candidat refusé.'); ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Expérience</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($candidatures as $candidat): ?>
                <tr>
                    <td><?php echo htmlspecialchars($candidat['name']); ?></td>
                    <td><?php echo htmlspecialchars($candidat['email']); ?></td>
                    <td><?php echo htmlspecialchars($candidat['phone']); ?></td>
                    <td><?php echo htmlspecialchars($candidat['experience']); ?></td>
                    <td><?php echo htmlspecialchars($candidat['message']); ?></td>
                    <td>
                        <form action="action_guide.php" method="POST" style="display:inline;">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($candidat['email']); ?>">
                            <input type="hidden" name="action" value="accept">
                            <button type="submit" class="btn btn-success">Accepter</button>
                        </form>
                        <form action="action_guide.php" method="POST" style="display:inline;">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($candidat['email']); ?>">
                            <input type="hidden" name="action" value="refuse">
                            <button type="submit" class="btn btn-danger">Refuser</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
