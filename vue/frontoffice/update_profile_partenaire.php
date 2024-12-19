<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté et si son rôle est "partenaire"
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'partenaire') {
    header("Location: login.php"); // Si non, rediriger vers la page de connexion
    exit();
}

// Inclure la configuration pour la connexion à la base de données
include '../../config.php';

// Connexion à la base de données
$pdo = config::getConnexion();

// Récupérer les informations de l'utilisateur connecté
$userId = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$query->execute([$userId]);
$user = $query->fetch();

// Vérifier si les informations de l'utilisateur existent
if (!$user) {
    die("Utilisateur non trouvé.");
}

// Récupérer les données du formulaire après la soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $entreprise = htmlspecialchars(trim($_POST['entreprise']));
    $secteur = htmlspecialchars(trim($_POST['secteur']));
    $site_web = htmlspecialchars(trim($_POST['site_web']));
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirm_mot_de_passe = $_POST['confirm_mot_de_passe'];

    // Validation des champs
    if (empty($nom) || empty($prenom) || empty($email) || empty($entreprise) || empty($secteur) || empty($site_web) || empty($telephone) || empty($adresse)) {
        die('Tous les champs obligatoires doivent être remplis.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Adresse e-mail invalide.');
    }

    // Vérifier si le mot de passe a été modifié
    if (!empty($mot_de_passe) && $mot_de_passe !== $confirm_mot_de_passe) {
        die('Les mots de passe ne correspondent pas.');
    }

    // Hachage du mot de passe si modifié
    if (!empty($mot_de_passe)) {
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);
    }

    try {
        // Mise à jour des informations dans la base de données
        if (!empty($mot_de_passe)) {
            $updateStmt = $pdo->prepare("
                UPDATE users 
                SET nom = ?, prenom = ?, email = ?, entreprise = ?, secteur = ?, site_web = ?, telephone = ?, adresse = ?, mot_de_passe = ?
                WHERE id = ?
            ");
            $updateStmt->execute([$nom, $prenom, $email, $entreprise, $secteur, $site_web, $telephone, $adresse, $mot_de_passe_hache, $userId]);
        } else {
            $updateStmt = $pdo->prepare("
                UPDATE users 
                SET nom = ?, prenom = ?, email = ?, entreprise = ?, secteur = ?, site_web = ?, telephone = ?, adresse = ?
                WHERE id = ?
            ");
            $updateStmt->execute([$nom, $prenom, $email, $entreprise, $secteur, $site_web, $telephone, $adresse, $userId]);
        }

        // Mettre à jour la session avec les nouvelles informations
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['email'] = $email;
        $_SESSION['entreprise'] = $entreprise;
        $_SESSION['secteur'] = $secteur;
        $_SESSION['site_web'] = $site_web;
        $_SESSION['telephone'] = $telephone;
        $_SESSION['adresse'] = $adresse;
        
        header("Location: indextemplate.php"); // Rediriger vers la page de profil
        exit();
        // Message de confirmation
        echo "Informations mises à jour avec succès !";
       
    } catch (PDOException $e) {
        // Gestion des erreurs
        error_log("Erreur lors de la mise à jour : " . $e->getMessage());
        die("Erreur lors de la mise à jour. Veuillez réessayer plus tard.");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Profil Partenaire</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Modifier Profil - Partenaire</h2>
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

            <!-- Entreprise -->
            <label for="entreprise">Entreprise</label>
            <input type="text" id="entreprise" name="entreprise" value="<?= htmlspecialchars($user['entreprise']) ?>" required>

            <!-- Secteur -->
            <label for="secteur">Secteur</label>
            <input type="text" id="secteur" name="secteur" value="<?= htmlspecialchars($user['secteur']) ?>" required>

            <!-- Site Web -->
            <label for="site_web">Site Web</label>
            <input type="url" id="site_web" name="site_web" value="<?= htmlspecialchars($user['site_web']) ?>" required>

            <!-- Téléphone -->
            <label for="telephone">Téléphone</label>
            <input type="text" id="telephone" name="telephone" value="<?= htmlspecialchars($user['telephone']) ?>" required>

            <!-- Adresse -->
            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($user['adresse']) ?>" required>

            <!-- Nouveau mot de passe -->
            <label for="mot_de_passe">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe">

            <!-- Confirmer le mot de passe -->
            <label for="confirm_mot_de_passe">Confirmer le nouveau mot de passe</label>
            <input type="password" id="confirm_mot_de_passe" name="confirm_mot_de_passe">

            <button type="submit">Mettre à jour</button>
        </form>
        <a href="partenaire_profile.php">Retour à votre profil</a>
    </div>
</body>
</html>
