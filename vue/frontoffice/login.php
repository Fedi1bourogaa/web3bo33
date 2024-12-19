<?php

include '../../config.php';

// Connexion à la base de données
$pdo = config::getConnexion();

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $email = htmlspecialchars(trim($_POST['email']));
    $mot_de_passe = $_POST['mot_de_passe'];

   
    if (empty($email) || empty($mot_de_passe)) {
        $_SESSION['error_message'] = 'Tous les champs doivent être remplis.';
        header('Location: login.php');  // Redirection pour rester sur la même page
        exit();
    }

    try {
        // Préparer la requête pour récupérer l'utilisateur par son email
        $checkUserStmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $checkUserStmt->execute([$email]);
        $user = $checkUserStmt->fetch(PDO::FETCH_ASSOC);

        // Vérification si l'utilisateur existe
        if (!$user) {
            $_SESSION['error_message'] = 'Erreur : Aucune correspondance pour cet email.';
            header('Location: login.php');  // Redirection pour rester sur la même page
            exit();
        }

        // Vérification du mot de passe
        if (!password_verify($mot_de_passe, $user['mot_de_passe'])) {
            $_SESSION['error_message'] = 'Mot de passe incorrect.';
            header('Location: login.php');  // Redirection pour rester sur la même page
            exit();
        }

        // Enregistrement des informations utilisateur dans la session
$_SESSION['user'] = [
    'id' => $user['id'],
    'prenom' => $user['prenom'],
    'nom' => $user['nom'],
    'email' => $user['email'],
    'role' => $user['role'],
];

        // Enregistrement des informations de l'utilisateur dans la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        

        // Redirection en fonction du rôle de l'utilisateur
        if ($user['role'] == 'admin') {
            header("Location: http://localhost/web3bo/vue/backoffice/admin_manage_users.php");
            exit();
        } elseif ($user['role'] == 'visiteur') {
            header("Location: indextemplate.php");
            exit();
        } elseif ($user['role'] == 'guide') {
            header("Location: indextemplate.php");
            exit();
        } elseif ($user['role'] == 'partenaire') {
            header("Location: indextemplate.php");
            exit();
        } else {
            die("Rôle inconnu.");
        }

    } catch (PDOException $e) {
        // Gestion des erreurs
        error_log("Erreur lors de la connexion : " . $e->getMessage());
        $_SESSION['error_message'] = 'Erreur lors de la connexion. Veuillez réessayer plus tard.';
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Connexion</h2>
    </header>
    
    <div class="form-container">
        <!-- Formulaire de connexion -->
        <form id="loginForm" method="POST" onsubmit="return validateForm()">
            <!-- Ajout des ID aux champs pour que le JS puisse les détecter -->
            <input type="email" id="email" name="email" placeholder="Email">
            <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe">
            <p>
             <a href="forgetpass.php">Mot de passe oublié ?</a>
           </p>
           <br>
            <button type="submit">Se connecter</button>
        </form>
    </div>

    <footer>
        <p>Pas encore inscrit ? <a href="index.php">S'inscrire</a></p>
    </footer>
   

    <script>
        function validateForm() {
            // Récupérer les valeurs des champs du formulaire
            var email = document.getElementById("email").value.trim();
            var mot_de_passe = document.getElementById("mot_de_passe").value.trim();

            // Vérifier si les champs sont vides
            if (!email || !mot_de_passe) {
                alert("Veuillez remplir tous les champs du formulaire.");
                return false;
            }

            // Vérification de l'email
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(email)) {
                alert("Veuillez entrer une adresse email valide.");
                return false;
            }

            // Vérification du mot de passe (longueur minimale de 8 caractères)
            if (mot_de_passe.length < 8) {
                alert("Le mot de passe doit contenir au moins 8 caractères.");
                return false;
            }

            // Si tout est valide
            return true; // Permet la soumission du formulaire
        }
    </script>
</body>
</html>

