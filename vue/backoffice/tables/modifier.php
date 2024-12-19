<?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$host = "localhost";
$dbname = "login";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification si un email a été envoyé
if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Récupération des données de l'utilisateur
    $sql = "SELECT email, num_fiscal, password FROM partenaires WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$utilisateur) {
        die("Utilisateur introuvable.");
    }
} else {
    die("Email non spécifié.");
}

// Vérification si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier que les champs nécessaires sont envoyés et non vides
    $errors = [];
    if (empty($_POST['email'])) {
        $errors[] = "L'email ne peut pas être vide.";
    }
    if (empty($_POST['num_fiscal'])) {
        $errors[] = "Le numéro fiscal ne peut pas être vide.";
    }
    if (empty($_POST['password'])) {
        $errors[] = "Le mot de passe ne peut pas être vide.";
    }

    // Si des erreurs existent, les afficher
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    } else {
        // Récupérer les données du formulaire
        $nouveau_email = $_POST['email'];
        $num_fiscal = $_POST['num_fiscal'];
        $password = $_POST['password'];

        // Mise à jour des données
        $sql = "UPDATE partenaires SET email = :nouveau_email, num_fiscal = :num_fiscal, password = :password WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nouveau_email', $nouveau_email, PDO::PARAM_STR);
        $stmt->bindParam(':num_fiscal', $num_fiscal, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // Redirection après la mise à jour
        header("Location: dashboard.php?message=updated");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
</head>
<body>
    <h1>Modifier les données de l'utilisateur</h1>
    <form action="" method="post">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($utilisateur['email']); ?>">

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($utilisateur['email']); ?>" required><br>

        <label for="num_fiscal">Numéro fiscal :</label>
        <input type="text" name="num_fiscal" id="num_fiscal" value="<?php echo htmlspecialchars($utilisateur['num_fiscal']); ?>" required><br>

        <label for="password">Mot de passe :</label>
        <input type="text" name="password" id="password" value="<?php echo htmlspecialchars($utilisateur['password']); ?>" required><br>

        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
