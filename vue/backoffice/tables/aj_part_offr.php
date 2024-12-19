<?php
require_once "C:/xampp/htdocs/elhadhra1/projet/controller/class_offre.php"; // Inclure la classe OffreC

$offreC = new OffreC(); // Créer une instance de la classe OffreC

// Récupérer toutes les offres pour les afficher dans le formulaire
$offres = $offreC->afficherOffres();

// Traitement du formulaire d'ajout de partenaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier que tous les champs sont remplis
    if (isset($_POST['nom'], $_POST['email'], $_POST['password'], $_POST['destination'])) {
        // Récupérer les informations du formulaire
        $nom = trim($_POST['nom']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $destination = trim($_POST['destination']); // La destination de l'offre

        // Validation des données
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p>Veuillez entrer un email valide.</p>";
        } else {
            // Ajouter le partenaire avec l'offre
            $result = $offreC->ajouterPartenaireAvecOffre($nom, $email, $password, $destination);

            if ($result === true) {
                echo "<p>Partenaire et offre ajoutés avec succès !</p>";
            } else {
                echo "<p>Erreur lors de l'ajout du partenaire et de l'offre. $result</p>";
            }
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
        <select id="destination" name="destination" required>
            <?php
            foreach ($offres as $offre) {
                echo '<option value="' . htmlspecialchars($offre['destination']) . '">' . htmlspecialchars($offre['destination']) . '</option>';
            }
            ?>
        </select>

        <button type="submit">Ajouter le Partenaire et l'Offre</button>
    </form>
</body>
</html>
