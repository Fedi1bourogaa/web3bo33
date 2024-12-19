<?php
session_start(); // Démarre la session pour stocker la valeur du CAPTCHA

require_once 'db.php'; // Inclut le fichier de connexion à la base de données

$error = ''; // Variable pour les erreurs
$success = ''; // Variable pour les messages de succès

// Fonction pour générer un CAPTCHA aléatoire
function generateCaptcha() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $captchaText = '';
    for ($i = 0; $i < 6; $i++) {
        $captchaText .= $characters[rand(0, strlen($characters) - 1)];
    }
    $_SESSION['captcha'] = $captchaText; // Stocke le CAPTCHA dans la session
}

// Si le CAPTCHA n'est pas déjà généré ou si le formulaire a été soumis, on le génère
if (!isset($_SESSION['captcha']) || isset($_POST['refreshCaptcha'])) {
    generateCaptcha();
}

// Traitement du formulaire lors de la soumission
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['refreshCaptcha'])) {
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $num_fiscal = preg_replace("/[^0-9]/", "", trim($_POST['num_fiscal'])); // Sanitize num_fiscal
    $nom = trim($_POST['nom']);
    $captcha = trim($_POST['captcha']); // CAPTCHA de l'utilisateur

    // Vérification des champs obligatoires
    if (!empty($email) && !empty($password) && !empty($num_fiscal) && !empty($nom) && !empty($captcha)) {
        
        // Vérification de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Veuillez entrer une adresse e-mail valide.";
        }
        // Vérification de la longueur du mot de passe
        elseif (strlen($password) < 6) {
            $error = "Le mot de passe doit contenir au moins 6 caractères.";
        }
        // Vérification du CAPTCHA
        elseif (strtolower($captcha) !== strtolower($_SESSION['captcha'])) {
            $error = "Le code CAPTCHA est incorrect.";
        } else {
            try {
                // Vérification si l'email existe déjà dans la base de données
                $stmt = $pdo->prepare("SELECT email FROM partenaires WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->fetch()) {
                    $error = "Cette adresse e-mail est déjà utilisée.";
                } else {
                    // Hashage du mot de passe
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Insertion des données dans la base de données
                    $stmt = $pdo->prepare("INSERT INTO partenaires (nom, email, password, num_fiscal) VALUES (:nom, :email, :password, :num_fiscal)");
                    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                    $stmt->bindParam(':num_fiscal', $num_fiscal, PDO::PARAM_STR);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        $success = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
                    } else {
                        $error = "Une erreur est survenue lors de l'enregistrement.";
                    }
                }
            } catch (PDOException $e) {
                $error = "Erreur lors de la création du compte : " . $e->getMessage();
            }
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
    <title>Créer un compte</title>
    <style>
        /* Styles de la page */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff;
        }
        .register-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
        }
        .register-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .register-container label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }
        .register-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .register-container button:hover {
            background-color: #0056b3;
        }
        .register-container .message {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
        .message.error {
            color: red;
        }
        .message.success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Créer un compte</h1>

        <!-- Affichage des messages d'erreur ou de succès -->
        <?php if (!empty($error)) : ?>
            <p class="message error"><?php echo htmlspecialchars($error); ?></p>
        <?php elseif (!empty($success)) : ?>
            <p class="message success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <!-- Formulaire d'inscription -->
        <form action="" method="POST">
            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email" placeholder="Entrez votre e-mail" >
            
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" >
            
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" placeholder="Entrez un mot de passe" >
            
            <label for="num_fiscal">Numéro fiscal :</label>
            <input type="text" id="num_fiscal" name="num_fiscal" placeholder="Entrez votre numéro fiscal" >

            <!-- Affichage du CAPTCHA -->
            <label for="captcha">Captcha :</label>
            <div id="captcha"><?php echo htmlspecialchars($_SESSION['captcha']); ?></div>
            <input type="text" id="captchaInput" name="captcha" placeholder="Entrez le texte ci-dessus" >

            <!-- Bouton pour rafraîchir le CAPTCHA -->
            <button type="submit" name="refreshCaptcha" style="background-color: #28a745;">Rafraîchir CAPTCHA</button>
            <button type="submit">Créer un compte</button>
        </form>
    </div>
</body>
</html>
