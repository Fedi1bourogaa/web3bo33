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

// Traitement de l'ajout de l'offre
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reference = trim($_POST['reference']);
    $destination = trim($_POST['destination']);
    $prix = trim($_POST['prix']);

    if (!empty($reference) && !empty($destination) && !empty($prix)) {
        // Insertion de l'offre dans la base de données
        $sql = "INSERT INTO offre (reference, destination, prix) VALUES (:reference, :destination, :prix)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':reference', $reference);
        $stmt->bindParam(':destination', $destination);
        $stmt->bindParam(':prix', $prix);

        if ($stmt->execute()) {
            header("Location: offre.php?message=added");
            exit();
        } else {
            $error = "Erreur lors de l'ajout de l'offre.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Offre</title>
    <style>
        /* Votre CSS */
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Ajouter une Offre</h1>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="ajouter_offre.php" method="POST">
            <label for="reference">Référence</label>
            <input type="text" id="reference" name="reference" required>

            <label for="destination">Destination</label>
            <input type="text" id="destination" name="destination" required>

            <label for="prix">Prix (€)</label>
            <input type="number" id="prix" name="prix" required>

            <button type="submit">Ajouter l'Offre</button>
        </form>
    </div>

</body>
</html>
