<?php
// Démarre la session pour récupérer l'utilisateur connecté
session_start();

// Configuration de la connexion à la base de données
$host = 'localhost';
$dbname = 'elhadhra'; // Remplacez par le nom de votre base de données
$username = 'root';   // Remplacez par votre utilisateur MySQL
$password = '';       // Remplacez par votre mot de passe MySQL

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Erreur : Vous devez être connecté pour postuler.");
}

$id_user = $_SESSION['user_id']; // Récupérer l'ID utilisateur depuis la session

// Vérifier que la requête est bien un POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $experience = trim($_POST['experience']);
    $message = trim($_POST['message']);

    // Validation des champs (tous doivent être remplis)
    if (!empty($name) && !empty($email) && !empty($phone) && !empty($message)) {
        try {
            // Préparer la requête SQL pour insérer les données
            $sql = "INSERT INTO guides (name, id_user, email, phone, experience, message) 
                    VALUES (:name, :id_user, :email, :phone, :experience, :message)";
            $stmt = $pdo->prepare($sql);

            // Exécuter la requête
            $stmt->execute([
                ':name' => $name,
                ':id_user' => $id_user, // ID utilisateur récupéré depuis la session
                ':email' => $email,
                ':phone' => $phone,
                ':experience' => $experience,
                ':message' => $message,
            ]);

            echo "Votre candidature a été envoyée avec succès.";
        } catch (PDOException $e) {
            echo "Erreur lors de l'enregistrement de votre candidature : " . $e->getMessage();
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>