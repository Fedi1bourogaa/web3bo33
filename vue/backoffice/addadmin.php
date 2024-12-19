<?php
include '../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Vérification des mots de passe
    if ($mot_de_passe !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        try {
            // Hachage du mot de passe
            $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            // Connexion à la base de données
            $pdo = config::getConnexion();

            // Requête SQL d'insertion
            $sql = "INSERT INTO users (nom, prenom, email, mot_de_passe, role) VALUES (:nom, :prenom, :email, :mot_de_passe, 'admin')";
            $stmt = $pdo->prepare($sql);

            // Exécution de la requête
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':mot_de_passe' => $hashed_password,
            ]);

            // Redirection après succès
            header("Location: admin_manage_users.php?success=admin_added");
            exit;
        } catch (PDOException $e) {
            $error = "Erreur lors de l'ajout : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Admin | El Hadhra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('tunisia-background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }
        .form-container {
            width: 50%;
            margin: 100px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #b71c1c;
            border-radius: 4px;
        }
        button {
            padding: 10px;
            background-color: #b71c1c;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #a01717;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Ajouter un Admin</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" required>
            
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" required>
            
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
            
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required>
            
            <label for="confirm_password">Confirmer le mot de passe</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            
            <button type="submit">Ajouter Admin</button>
        </form>
    </div>
</body>
</html>
