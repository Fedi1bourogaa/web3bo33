<?php
session_start();
include '../../config.php';

$pdo = config::getConnexion();

// Inclure les fichiers nécessaires de PHPMailer
include '../../phpmailer/src/PHPMailer.php';  // Vérifiez le chemin exact vers PHPMailer.php
include '../../phpmailer/src/SMTP.php';      // Vérifiez le chemin exact vers SMTP.php
include '../../phpmailer/src/Exception.php'; // Vérifiez le chemin exact vers Exception.php

// Création de l'instance PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));

    try {
        // Vérification de l'existence de l'email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Créer un lien de réinitialisation (avec l'email dans l'URL)
            $resetLink = "http://localhost/web3bo/vue/frontoffice/resetpass.php?email=$email";
            $subject = "Réinitialisation de mot de passe";
            $message = "Bonjour,\n\nCliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink\n\nCe lien expire dans 24 heures.";
            
            // Configuration de PHPMailer pour Gmail
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'koussaylaifi2004@gmail.com';  // Votre adresse email Gmail
            $mail->Password = 'rdvn rpeq runs xuxf';  // Votre mot de passe Gmail ou mot de passe d'application
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            
            // Destinataire et expéditeur
            $mail->setFrom('koussaylaifi2004@gmail.com', 'No Reply');
            $mail->addAddress($email);

            // Contenu du mail
            $mail->Subject = $subject;
            $mail->Body    = $message;

            // Envoi du mail
            if ($mail->send()) {
                $_SESSION['success_message'] = "Un email de réinitialisation a été envoyé à $email.";
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'envoi de l'email. Veuillez réessayer.";
            }
        } else {
            $_SESSION['error_message'] = "Aucun compte trouvé pour cet email.";
        }
    } catch (Exception $e) {
        error_log("Erreur lors du traitement : " . $e->getMessage());
        $_SESSION['error_message'] = "Une erreur est survenue. Veuillez réessayer.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Mot de passe oublié</h2>
    </header>
    
    <div class="form-container">
        <?php
        if (isset($_SESSION['success_message'])) {
            echo "<p class='success-message'>" . $_SESSION['success_message'] . "</p>";
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo "<p class='error-message'>" . $_SESSION['error_message'] . "</p>";
            unset($_SESSION['error_message']);
        }
        ?>
        
        <form method="POST" action="">
            <label for="email">Entrez votre email :</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Envoyer le lien de réinitialisation</button>
        </form>
    </div>

    <footer>
        <p><a href="login.php">Retour à la connexion</a></p>
    </footer>
</body>
</html>
