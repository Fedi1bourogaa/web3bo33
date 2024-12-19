<?php

include '../../config.php'; 

$pdo = config::getConnexion();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $specialite = $_POST['specialite'];
    $langues = isset($_POST['langues']) ? $_POST['langues'] : [];

    // Si $langues est un tableau, convertir en chaîne pour l'insertion
    if (is_array($langues)) {
        $langues = implode(', ', $langues);
    }
    /*$string = implode(', ', $array);
   
    $photo = $_FILES['photo']['name'];  // Nom de l'image téléchargée*/

    // Validation que les mots de passe correspondent
    if ($mot_de_passe !== $_POST['confirm_mot_de_passe']) {
        die('Les mots de passe ne correspondent pas.');
    }

    // Hachage du mot de passe
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);

     // Vérification si l'email existe déjà
     try {
        $pdo = config::getConnexion();
        $checkEmailStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $checkEmailStmt->execute([$email]);
        $emailExists = $checkEmailStmt->fetchColumn();

        if ($emailExists > 0) {
            die("Erreur : Cet e-mail est déjà utilisé.");
        }

        // Insertion de l'utilisateur si l'email n'existe pas
        $insertStmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, mot_de_passe, role, specialite, langues)
                                     VALUES (?, ?, ?, ?, 'guide', ?, ?)");
        $insertStmt->execute([$nom, $prenom, $email, $mot_de_passe_hache, $specialite, $langues]);
         //message de confirmation
        echo "Guide inscrit avec succès !";


        // Redirection après succès
        header("Location: indextemplate.php"); // Redirige vers indextemplate.php
        exit(); // Terminer l'exécution du script après la redirection

    } catch (PDOException $e) {
        die("Erreur lors de l'insertion : " . $e->getMessage());
    }

    

    // Insertion des données dans la base de données
    try {
        
       $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, mot_de_passe, role, specialite, langues)
       VALUES (?, ?, ?, ?, 'guide', ?, ?)");

        // Exécution de la requête avec les données récupérées
        $stmt->execute([$nom, $prenom, $email, $mot_de_passe, $specialite, $langues]);

        // Message de confirmation
        echo "Guide inscrit avec succès !";
    } catch (PDOException $e) {
        die("Erreur lors de l'insertion des données : " . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Guide - El Hadhra</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Inscription - Guide de Voyage</h2>
    </header>
    
    <div class="form-container">
        <form id="guideRegistrationForm" method="POST" onsubmit="return validateForm()">
            <!-- Champ Nom -->
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" placeholder="Nom" >

            <!-- Champ Prénom -->
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" placeholder="Prénom">

            <!-- Champ Email -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" >

            <!-- Champ Mot de passe -->
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe"  >

            <!-- Champ Confirmation Mot de passe -->
            <label for="confirm_mot_de_passe">Confirmer le mot de passe</label>
            <input type="password" id="confirm_mot_de_passe" name="confirm_mot_de_passe" >

            <!-- Champ Spécialité -->
            <label for="specialite">Spécialité du guide</label>
            <input type="text" id="specialite" name="specialite" placeholder="Ex : Histoire, Nature, Culture">

            <!-- Champ Langues parlées -->
            <label for="langues">Langues parlées</label>
            <select id="langues" name="langues" multiple >
                <option value="francais">Français</option>
                <option value="anglais">Anglais</option>
                <option value="espagnol">Espagnol</option>
                <option value="arabe">Arabe</option>
                <option value="allemand">Allemand</option>
                <option value="italien">Italien</option>
            </select>
            
            <button type="submit">S'inscrire</button>
        </form>
    </div>

    <footer>
        <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
    </footer>

    <script>
    function validateForm() {
        // Récupérer tous les champs du formulaire
        var nom = document.getElementById("nom").value.trim();
        var prenom = document.getElementById("prenom").value.trim();
        var email = document.getElementById("email").value.trim();
        var mot_de_passe = document.getElementById("mot_de_passe").value.trim();
        var confirm_mot_de_passe = document.getElementById("confirm_mot_de_passe").value.trim();
        var specialite = document.getElementById("specialite").value.trim();
        var langues = document.getElementById("langues").selectedOptions;

        // Vérifier si un champ est vide
        if (!nom || !prenom || !email || !mot_de_passe || !confirm_mot_de_passe || !specialite || langues.length === 0) {
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

        // Vérification des mots de passe
        if (mot_de_passe !== confirm_mot_de_passe) {
            alert("Les mots de passe ne correspondent pas.");
            return false;
        }

        // Vérification des langues
        if (langues.length === 0) {
            alert("Veuillez sélectionner au moins une langue.");
            return false;
        }

        // Si tout est valide
        return true;
    }
</script>
</html>
