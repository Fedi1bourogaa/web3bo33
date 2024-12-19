<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'elhadhra'; // Remplacez par le nom de votre base
$username = 'root'; // Remplacez par votre utilisateur
$password = ''; // Remplacez par votre mot de passe

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer les données du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $action = $_POST['action'];

    if ($action === 'accept') {
        // Récupérer les informations du candidat dans `guides`
        $sql = "SELECT * FROM guides WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $candidat = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($candidat) {
            // Vérifier si 'name' est valide
            if (empty($candidat['name'])) {
                die("Erreur : Le champ 'name' est vide pour cet utilisateur.");
            }

            // Générer un mot de passe par défaut (exemple : 'guide123') et le hacher
            $mot_de_passe = password_hash('guide123', PASSWORD_BCRYPT);

            // Ajouter le candidat à la table "users" avec le rôle "guide"
            $sql = "INSERT INTO users (nom, email, mot_de_passe, role) 
                    VALUES (:nom, :email, :mot_de_passe, 'guide')";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nom', $candidat['name']);
            $stmt->bindParam(':email', $candidat['email']);
            $stmt->bindParam(':mot_de_passe', $mot_de_passe);
            $stmt->execute();

            // Supprimer le candidat de la table "guides"
            $sql = "DELETE FROM guides WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            header("Location: dashboard_guide.php?message=accepted");
            exit();
        }
    } elseif ($action === 'refuse') {
        // Supprimer le candidat de la table "guides"
        $sql = "DELETE FROM guides WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        header("Location: dashboard_guide.php?message=refused");
        exit();
    }
}
?>
