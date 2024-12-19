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

// Récupérer l'offre à modifier
if (isset($_GET['reference'])) {
    $reference = $_GET['reference'];

    // Récupérer les données de l'offre à modifier
    $sql = "SELECT * FROM offre WHERE reference = :reference";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':reference', $reference);
    $stmt->execute();
    $offre = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$offre) {
        die("Offre non trouvée.");
    }

    // Traitement de la mise à jour
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $destination = trim($_POST['destination']);
        $prix = trim($_POST['prix']);

        if (!empty($destination) && !empty($prix)) {
            // Mise à jour de l'offre dans la base de données
            $updateSql = "UPDATE offre SET destination = :destination, prix = :prix WHERE reference = :reference";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->bindParam(':reference', $reference);
            $updateStmt->bindParam(':destination', $destination);
            $updateStmt->bindParam(':prix', $prix);

            if ($updateStmt->execute()) {
                // Rediriger vers la page des offres avec un message de confirmation
                header("Location: offre.php?message=updated");
                exit();
            } else {
                $error = "Erreur lors de la mise à jour de l'offre.";
            }
        } else {
            $error = "Veuillez remplir tous les champs.";
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
    <title>Modifier une Offre</title>
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
        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
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
        <h1>Modifier une Offre</h1>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="modifier_offre.php?reference=<?php echo htmlspecialchars($offre['reference']); ?>" method="POST">
            <label for="reference">Référence (non modifiable)</label>
            <input type="text" id="reference" name="reference" value="<?php echo htmlspecialchars($offre['reference']); ?>" disabled>

            <label for="destination">Destination</label>
            <input type="text" id="destination" name="destination" value="<?php echo htmlspecialchars($offre['destination']); ?>" required>

            <label for="prix">Prix (€)</label>
            <input type="number" id="prix" name="prix" value="<?php echo htmlspecialchars($offre['prix']); ?>" required>

            <button type="submit">Mettre à jour</button>
        </form>
    </div>

</body>
</html>
