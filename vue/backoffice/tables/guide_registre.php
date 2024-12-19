?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc); /* Dégradé de fond */
            background: url('background.jpg') no-repeat center center fixed; 
            background-size: cover;

            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff; /* Pour que le texte contraste avec le fond */
        }
        .register-container {
            background: rgba(255, 255, 255, 0.9); /* Fond semi-transparent pour le formulaire */
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
        <form action="login_guide.php" method="POST">
            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email" placeholder="Entrez votre e-mail" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" placeholder="Entrez un mot de passe" required>

            <label for="numero_guide">Numéro de guide :</label>
            <input type="text" id="numero_guide" name="numero_guide" placeholder="Entrez votre numéro de guide" required>

            <button type="submit">Créer un compte</button>
        </form>
    </div>
</body>
</html>