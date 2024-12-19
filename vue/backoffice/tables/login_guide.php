<?php
require_once 'db.php'; // Inclusion du fichier pour la connexion à la base de données

$error = ''; // Variable pour les erreurs
$success = ''; // Variable pour les messages de succès

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $numero_guide = trim($_POST['numero_guide']);

    // Vérification que tous les champs sont remplis
    if (!empty($email) && !empty($password) && !empty($numero_guide)) {
        // Validation de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Veuillez entrer une adresse e-mail valide.";
        } elseif (strlen($password) < 6) { 
            $error = "Le mot de passe doit contenir au moins 6 caractères.";
        } else {
            try {
                // Vérification si l'email existe déjà dans la base
                $stmt = $pdo->prepare("SELECT email FROM guide WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->fetch()) {
                    $error = "Cette adresse e-mail est déjà utilisée.";
                } else {
                    // Hashage du mot de passe
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Insertion des données dans la base
                    $stmt = $pdo->prepare("INSERT INTO guide (email, password, numero_guide) VALUES (:email, :password, :numero_guide)");
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                    $stmt->bindParam(':numero_guide', $numero_guide, PDO::PARAM_STR);
                    $stmt->execute();

                    $success = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
                }
            } catch (PDOException $e) {
                $error = "Erreur lors de la création du compte : " . $e->getMessage();
            }
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}