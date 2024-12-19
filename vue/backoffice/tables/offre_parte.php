<?php
require_once "C:/xampp/htdocs/elhadhra1/projet/controller/class_offre.php"; // Inclure la classe OffreC
require_once "config.php"; // Inclure la configuration de la base de données

$offreC = new OffreC(); // Créer une instance de la classe OffreC

// Traitement du formulaire d'ajout de partenaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nom'], $_POST['email'], $_POST['password'], $_POST['destination'])) {
        // Récupérer les informations du formulaire
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $destination = $_POST['destination']; // La destination de l'offre

        // Ajouter l'offre et le partenaire
        $result = $offreC->ajouterPartenaireAvecOffre($nom, $email, $password, $destination);

        if ($result) {
            echo "<p>Partenaire et offre ajoutés avec succès !</p>";
        } else {
            echo "<p>Erreur lors de l'ajout du partenaire et de l'offre.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Partenaire avec Offre</title>
</head>
<body>
    <h1>Ajouter un Partenaire avec une Offre</h1>

    <form method="POST">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <label for="destination">Destination de l'offre:</label>
        <input type="text" id="destination" name="destination" required>

        <button type="submit">Ajouter le Partenaire et l'Offre</button>
    </form>
</body>
</html>
