<?php
include '../../config.php'; 

// Connexion à la base de données via la classe config
$pdo = config::getConnexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirm_mot_de_passe = $_POST['confirm_mot_de_passe'];
    $entreprise = $_POST['entreprise'];
    $secteur = $_POST['secteur'];
    $site_web = $_POST['site_web'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];

    // Validation des mots de passe
    if ($mot_de_passe !== $confirm_mot_de_passe) {
        die('Les mots de passe ne correspondent pas.');
    }

    // Hachage du mot de passe
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);

    // Vérification si l'email existe déjà
    try {
        $checkEmailStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $checkEmailStmt->execute([$email]);
        $emailExists = $checkEmailStmt->fetchColumn();

        if ($emailExists > 0) {
            die("Erreur : Cet e-mail est déjà utilisé.");
        }

        // Insertion de l'utilisateur dans la table 'users'
        $insertStmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, mot_de_passe, role, entreprise, secteur, site_web, telephone, adresse)
                                     VALUES (?, ?, ?, ?, 'partenaire', ?, ?, ?, ?, ?)");
        $insertStmt->execute([$nom, $prenom, $email, $mot_de_passe_hache, $entreprise, $secteur, $site_web, $telephone, $adresse]);

     
        //message de confirmation
        echo "Partenaire inscrit avec succès !";


            // Redirection après succès
            header("Location: indextemplate.php"); // Redirige vers indextemplate.php
            exit(); // Terminer l'exécution du script après la redirection
    } catch (PDOException $e) {
        die("Erreur lors de l'insertion : " . $e->getMessage());
    }
}
?>






<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Partenaire - El Hadhra</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Inscription - Partenaire</h2>
    </header>
    
    <div class="form-container">
        <form id="partenaireRegistrationForm" method="POST" onsubmit="return validateForm()">
            <!-- Champ Nom -->
            <label for="nom">Nom </label>
            <input type="text" id="nom" name="nom" placeholder="Nom " >

            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" placeholder="Prénom" >

            <!-- Champ Email -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" >

            <!-- Champ Mot de passe -->
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" >
            
            <!-- Champ Confirmation Mot de passe -->
             <label for="confirm_mot_de_passe">Confirmer le mot de passe</label>
            <input type="password" id="confirm_mot_de_passe" name="confirm_mot_de_passe" >

            <!-- Champ Nom de l'entreprise -->
            <label for="entreprise">Nom de l'entreprise</label>
            <input type="text" id="entreprise" name="entreprise" placeholder="Nom de l'entreprise" >

            <!-- Champ Secteur d'activité -->
            <label for="secteur">Secteur d'activité</label>
            <input type="text" id="secteur" name="secteur" placeholder="Secteur d'activité" >

            <!-- Champ Site Web -->
            <label for="site_web">Site Web</label>
            <input type="url" id="site_web" name="site_web" placeholder="https://www.example.com">

            <!-- Champ Téléphone -->
            <label for="telephone">Téléphone</label>
            <input type="tel" id="telephone" name="telephone" placeholder="Téléphone" >

            <!-- Champ Adresse -->
            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" name="adresse" placeholder="Adresse complète" >

            <!-- Soumettre le formulaire -->
            <button type="submit">S'inscrire</button>
        </form>
    </div>

    <footer>
        <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
    </footer>
    <script>
        function validateForm() {
            // Récupération des valeurs des champs
            var nom = document.getElementById("nom").value.trim();
            var prenom = document.getElementById("prenom").value.trim();
            var email = document.getElementById("email").value.trim();
            var mot_de_passe = document.getElementById("mot_de_passe").value.trim();
            var confirm_mot_de_passe = document.getElementById("confirm_mot_de_passe").value.trim();
            var entreprise = document.getElementById("entreprise").value.trim();
            var secteur = document.getElementById("secteur").value.trim();
            var site_web = document.getElementById("site_web").value.trim();
            var telephone = document.getElementById("telephone").value.trim();
            var adresse = document.getElementById("adresse").value.trim();

            // Vérification si tous les champs sont remplis
            if (!nom || !prenom || !email || !mot_de_passe || !confirm_mot_de_passe || 
                !entreprise || !secteur || !site_web || !telephone || !adresse) {
                alert("Veuillez remplir tous les champs du formulaire.");
                return false;
            }

            // Vérification du nom
            if (!/^[A-Za-zÀ-ÿ ]+$/.test(nom)) {
                alert("Le nom doit contenir uniquement des lettres et des espaces.");
                return false;
            }

            // Vérification du prénom
            if (!/^[A-Za-zÀ-ÿ ]+$/.test(prenom)) {
                alert("Le prénom doit contenir uniquement des lettres et des espaces.");
                return false;
            }

            // Vérification de l'email
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(email)) {
                alert("Veuillez entrer une adresse email valide.");
                return false;
            }

            // Vérification du mot de passe
            if (mot_de_passe.length < 8) {
                alert("Le mot de passe doit contenir au moins 8 caractères.");
                return false;
            }

            // Vérification de la confirmation du mot de passe
            if (mot_de_passe !== confirm_mot_de_passe) {
                alert("Les mots de passe ne correspondent pas.");
                return false;
            }

            // Vérification du site web
            var urlPattern = /^(https?:\/\/)?(www\.)?[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!urlPattern.test(site_web)) {
                alert("Veuillez entrer une URL valide pour le site web.");
                return false;
            }

            // Vérification du téléphone
            if (!/^\d{8,15}$/.test(telephone)) {
                alert("Le numéro de téléphone doit contenir entre 8 et 15 chiffres.");
                return false;
            }

            // Si toutes les validations passent
            return true;
        }
    </script>
    
</body>
</html>
