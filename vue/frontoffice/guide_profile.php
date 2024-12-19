<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté et si son rôle est "guide"
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'guide') {
    header("Location: login.php"); // Si non, rediriger vers la page de connexion
    exit();
}

// Inclure la configuration pour la connexion à la base de données
include '../../config.php';

// Connexion à la base de données
$pdo = config::getConnexion();

// Récupérer les informations de l'utilisateur depuis la base de données
$userId = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$query->execute([$userId]);
$user = $query->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur existe dans la base de données
if (!$user) {
    die("Utilisateur non trouvé.");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Visiteur</title>
 

    <style>
       /* Style global */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: url('tunisia-background.jpg') no-repeat center center fixed; /* Remplacer 'background-image.jpg' par l'URL de ton image */
    background-size: cover;
    color: #fff;
    text-align: center;
}

/* Header */
header {
    background-color: rgba(0, 0, 0, 0.7); /* Ombre foncée pour un meilleur contraste */
    color: #fff;
    padding: 20px;
}

h2 {
    font-size: 2.5em;
    margin: 0;
    color: #cc0000; /* Couleur rouge pour le titre h2 */
}

/* Conteneur de profil */
.profile-container {
    max-width: 600px;
    margin: 40px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.9); /* Fond blanc avec légère transparence */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

h3 {
    font-size: 1.8em;
    color: #cc0000; /* Rouge pour les titres */
    margin-bottom: 20px;
}

/* Texte des informations */
p {
    font-size: 1.1em;
    margin: 10px 0;
    color: #333; /* Texte en noir pour plus de lisibilité */
}

/* Formulaire de mise à jour */
form {
    display: flex;
    flex-direction: column;
}

label {
    font-size: 1.1em;
    margin: 10px 0 5px;
    color: #333; /* Noir pour les labels */
}

input[type="text"],
input[type="email"],
input[type="password"] {
    padding: 12px;
    font-size: 1em;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    box-sizing: border-box;
    background-color: #f9f9f9; /* Fond clair pour les champs de formulaire */
}

button {
    padding: 12px;
    background-color: #cc0000; /* Rouge pour le bouton */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1.2em;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #b30000; /* Rouge plus foncé au survol */
}

a {
    color: #cc0000; /* Rouge pour les liens */
    text-decoration: none;
    margin-top: 20px;
    font-size: 1.2em;
}

a:hover {
    text-decoration: underline;
}

/* Footer */
footer {
    text-align: center;
    background-color: rgba(0, 0, 0, 0.7); /* Fond noir pour le footer */
    color: white;
    padding: 10px;
    margin-top: 40px;
}

/* Responsivité */
@media (max-width: 768px) {
    body {
        font-size: 14px;
    }

    .profile-container {
        margin: 20px;
        padding: 15px;
    }

    h2 {
        font-size: 2em;
    }

    h3 {
        font-size: 1.5em;
    }

    button {
        font-size: 1.1em;
    }
}

    </style>

</head>
<body align="center">
    <header>
        <h2>Profil de <?php echo htmlspecialchars($user['nom'] . ' ' . $user['prenom']); ?></h2>
    </header>
    
    <div class="profile-container">
        <h3>Informations personnelles</h3>
        
        <p><strong>Nom:</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
        <p><strong>Prénom:</strong> <?php echo htmlspecialchars($user['prenom']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>specialites:</strong> <?php echo htmlspecialchars($user['specialite']); ?></p>
        <p><strong>langues:</strong> <?php echo htmlspecialchars($user['langues']); ?></p>


        <!-- Formulaire de mise à jour des informations -->
        <h3>Mettre à jour mes informations</h3>
        <form action="update_profile_guide.php" method="POST">
        
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>

            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="specialite">spécialité</label>
            <input type="text" id="specialite" name="specialite" value="<?php echo htmlspecialchars($user['specialite']); ?>" required>

            <label for="langues">Langues</label>
            <input type="text" id="langues" name="langues" value="<?php echo htmlspecialchars($user['langues']); ?>" required>

            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Nouveau mot de passe" minlength="8">

            <label for="confirm_mot_de_passe">Confirmer le mot de passe</label>
            <input type="password" id="confirm_mot_de_passe" name="confirm_mot_de_passe" placeholder="Confirmer le mot de passe">

            <button type="submit">Mettre à jour</button>
            
        </form>
        

        <a href="logout.php">Se déconnecter</a>
    </div>

    <footer>
        <p>&copy; elhadhra</p>
    </footer>
</body>
</html>
