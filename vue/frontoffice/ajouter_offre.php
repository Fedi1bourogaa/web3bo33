<?php
session_start();

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$host = 'localhost';
$dbname = 'elhadhra';
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
    $imagePath = null;

    // Vérifier que tous les champs obligatoires sont remplis
    if (!empty($reference) && !empty($destination) && !empty($prix)) {
        // Gérer l'upload de l'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $fileName = uniqid() . '-' . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;

            // Créer le répertoire d'upload s'il n'existe pas
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Déplacer le fichier vers le répertoire d'upload
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = $uploadFile;
            } else {
                $error = "Erreur lors de l'upload de l'image.";
            }
        }

        // Insertion de l'offre dans la base de données
        $sql = "INSERT INTO offre (reference, destination, prix, image) VALUES (:reference, :destination, :prix, :image)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':reference', $reference);
        $stmt->bindParam(':destination', $destination);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':image', $imagePath);

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
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .form-container {
            width: 40%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-container input, .form-container button {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
        }
        .form-container button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Ajouter une Offre</h1>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="ajouter_offre.php" method="POST" enctype="multipart/form-data">
            <label for="reference">Référence</label>
            <input type="text" id="reference" name="reference" required>

            <label for="destination">Destination</label>
            <input type="text" id="destination" name="destination" required>

            <label for="prix">Prix (DT)</label>
            <input type="number" id="prix" name="prix" required>

            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit">Ajouter l'Offre</button>
        </form>
    </div>

</body>
</html>
