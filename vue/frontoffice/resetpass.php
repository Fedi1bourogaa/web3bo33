<?php
session_start();
include '../../config.php';

$pdo = config::getConnexion();

include '../../phpmailer/src/PHPMailer.php';
include '../../phpmailer/src/SMTP.php';
include '../../phpmailer/src/Exception.php';

// Vérifier si l'email est présent dans l'URL
if (isset($_GET['email'])) {
    $email = htmlspecialchars($_GET['email']);
    
    // Vérifier si l'email existe dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_password = htmlspecialchars($_POST['new_password']);
            $confirm_password = htmlspecialchars($_POST['confirm_password']);

            if ($new_password !== $confirm_password) {
                $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                header("Location: reset_password.php?email=$email");
                exit();
            }

            try {
                // Hacher le mot de passe et le mettre à jour dans la base de données
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare("UPDATE users SET mot_de_passe = ? WHERE email = ?");
                $updateStmt->execute([$hashed_password, $email]);

                $_SESSION['success_message'] = "Mot de passe réinitialisé avec succès.";
                header("Location: login.php");
                exit();
            } catch (Exception $e) {
                error_log("Erreur : " . $e->getMessage());
                $_SESSION['error_message'] = "Une erreur est survenue. Veuillez réessayer.";
                header("Location: reset_password.php?email=$email");
                exit();
            }
        }
    } else {
        $_SESSION['error_message'] = "Aucun compte trouvé pour cet email.";
        header("Location: forget_password.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Lien de réinitialisation invalide.";
    header("Location: forget_password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Réinitialiser votre mot de passe</h2>
    </header>
    
    <div class="form-container">
        <?php
        if (isset($_SESSION['error_message'])) {
            echo "<p class='error-message'>" . $_SESSION['error_message'] . "</p>";
            unset($_SESSION['error_message']);
        }
        if (isset($_SESSION['success_message'])) {
            echo "<p class='success-message'>" . $_SESSION['success_message'] . "</p>";
            unset($_SESSION['success_message']);
        }
        ?>

        <!-- Formulaire de réinitialisation -->
        <form method="POST" action="">
            <label for="new_password">Nouveau mot de passe :</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Réinitialiser</button>
        </form>
    </div>

    <footer>
        <p><a href="login.php">Retour à la connexion</a></p>
    </footer>
</body>
</html>
