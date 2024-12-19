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

// Récupérer la référence de l'offre à supprimer
if (isset($_GET['reference'])) {
    $reference = $_GET['reference'];

    // Vérification si l'offre existe
    $sql = "SELECT * FROM offre WHERE reference = :reference";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':reference', $reference);
    $stmt->execute();
    $offre = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$offre) {
        die("Offre non trouvée.");
    }

    // Traitement de la suppression
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Suppression de l'offre dans la base de données
        $deleteSql = "DELETE FROM offre WHERE reference = :reference";
        $deleteStmt = $pdo->prepare($deleteSql);
        $deleteStmt->bindParam(':reference', $reference);

        // Exécution de la suppression
        if ($deleteStmt->execute()) {
            // Vérification si l'exécution de la requête a réussi
            if ($deleteStmt->rowCount() > 0) {
                // Rediriger vers la page des offres avec un message de confirmation
                header("Location: offre.php?message=deleted");
                exit();
            } else {
                $error = "Aucune offre trouvée avec cette référence pour la suppression.";
            }
        } else {
            $error = "Erreur lors de la suppression de l'offre.";
        }
    }
} else {
    die("Référence non spécifiée.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer une Offre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 20px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .form-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .form-container p {
            text-align: center;
            font-size: 16px;
            color: #333;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #d9534f;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #c9302c;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Supprimer l'Offre</h1>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <p>Êtes-vous sûr de vouloir supprimer l'offre avec la référence <strong><?php echo htmlspecialchars($offre['reference']); ?></strong> ?</p>

        <form action="supprimer_offre.php?reference=<?php echo htmlspecialchars($offre['reference']); ?>" method="POST">
            <button type="submit">Supprimer l'offre</button>
        </form>

        <a href="offre.php">Annuler</a>
    </div>

</body>
</html>
