<?php
include '../../config.php';

// Vérifier si un ID a été passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = $_GET['id'];

    // Récupérer les informations de l'utilisateur à partir de la base de données
    try {
        $sql = "SELECT * FROM users WHERE id = :id"; // Récupère l'utilisateur par son ID
        $stmt = config::getConnexion()->prepare($sql);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            die("Utilisateur non trouvé.");
        }
    } catch (PDOException $e) {
        die("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
    }
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    
    // Mettre à jour les informations de l'utilisateur
    try {
        $sql = "UPDATE users SET nom = :nom, prenom = :prenom, email = :email, role = :role WHERE id = :id";
        $stmt = config::getConnexion()->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $user_id);

        $stmt->execute();
        
        // Rediriger vers la page de gestion des utilisateurs avec un message de succès
        header('Location: admin_manage_users.php?success=true');
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur | El Hadhra</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <div class="admin-container">
        <h2>Modifier profile</h2>
        
        <!-- Formulaire de modification de l'utilisateur -->
        <form action="admin_edit_user.php?id=<?= $user['id'] ?>" method="POST">
            <input type="hidden" name="id" value="<?= $user['id'] ?>"> <!-- ID utilisateur -->
            
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label for="role">Rôle :</label>
            <select id="role" name="role">
                <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                <option value="partenaire" <?= ($user['role'] == 'partenaire') ? 'selected' : '' ?>>Partenaire</option>
                <option value="visiteur" <?= ($user['role'] == 'visiteur') ? 'selected' : '' ?>>visiteur</option>
                <option value="guide" <?= ($user['role'] == 'guide') ? 'selected' : '' ?>>Guide</option>
            </select>

            <button type="submit">Mettre à jour</button>
        </form>
        
        <a href="admin_manage_users.php">Retour à la liste des utilisateurs</a>
    </div>
    <script src="javab.js"></script>
</body>
</html>




<!--<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur | El Hadhra</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <div class="admin-container">
        <h2>Modifier Utilisateur</h2>
        <form action="admin_edit_user" method="POST">
            <input type="hidden" name="id" value="1"> 
            
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="Nom actuel" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="Prénom actuel" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="email@example.com" required>

            <label for="role">Rôle :</label>
            <select id="role" name="role">
                <option value="admin">Admin</option>
                <option value="contributeur">partenaire</option>
                <option value="utilisateur">Utilisateur</option>
                <option value="contributeur">guide </option>
            </select>

            <button type="submit">Mettre à jour</button>
        </form>
        <a href="admin_manage_users.php">Retour à la liste des utilisateurs</a>
        
    </div>
    <script src="javab.js"></script>
</body>
</html>-->
