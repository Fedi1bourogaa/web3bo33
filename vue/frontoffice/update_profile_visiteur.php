<?php
// Démarrer la session
session_start();

// Vérification si le visiteur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'visiteur') {
    header("Location: login.php"); // Redirection vers la page de connexion si non connecté
    exit();
}

// Inclure la configuration pour la connexion à la base de données
include '../../config.php';

$pdo = config::getConnexion();
$userId = $_SESSION['user_id'];

// Récupérer les informations actuelles du visiteur
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Erreur : Utilisateur non trouvé.");
    }
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}

// Mettre à jour les informations si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
   


    // Vérification et hachage du mot de passe si fourni
    if (!empty($_POST['mot_de_passe']) && !empty($_POST['confirm_mot_de_passe'])) {
        if ($_POST['mot_de_passe'] !== $_POST['confirm_mot_de_passe']) {
            die("Erreur : Les mots de passe ne correspondent pas.");
        }
        $mot_de_passe_hache = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
    } else {
        $mot_de_passe_hache = $user['mot_de_passe']; // Conserver l'ancien mot de passe
    }

    // Mise à jour des données dans la base
    try {
        $stmt = $pdo->prepare("UPDATE users SET nom = ?, prenom = ?, email = ?, mot_de_passe = ? WHERE id = ?");
        $stmt->execute([$nom, $prenom, $email, $mot_de_passe_hache, $userId]);
        

        header("Location: indextemplate.php");
        exit();
        echo "Profil mis à jour avec succès.";
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour des données : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Profil Visiteur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Modifier Profil - Visiteur</h2>
        <form method="POST">
            <!-- Nom -->
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>

            <!-- Prénom -->
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>

            <!-- Email -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <!-- Nouveau mot de passe -->
            <label for="mot_de_passe">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe">

            <!-- Confirmer le mot de passe -->
            <label for="confirm_mot_de_passe">Confirmer le nouveau mot de passe</label>
            <input type="password" id="confirm_mot_de_passe" name="confirm_mot_de_passe">

                
            </select>

            <button type="submit">Mettre à jour</button>
        </form>
        <a href="indextemplate.php">Retour à l'accueil</a>
    </div>
</body>
</html>
