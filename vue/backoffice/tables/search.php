<?php
require_once "C:/xampp/htdocs/elhadhra1/projet/controller/class_offre.php"; // Inclure la classe OffreC

$offreC = new OffreC(); // Créer une instance de la classe OffreC

// Récupérer toutes les offres pour les afficher dans le formulaire
$offres = $offreC->afficherOffres();

// Traiter la recherche des partenaires associés à une offre
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['offre'])) {
        // Récupérer l'ID de l'offre sélectionnée
        $idOffre = $_POST['offre'];
        
        // Récupérer les partenaires associés à cette offre
        $partenaires = $offreC->afficherPartenaires($idOffre);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Partenaires par Offre</title>
</head>
<body>
    <h1>Recherche des Partenaires pour une Offre</h1>

    <!-- Formulaire de sélection d'offre -->
    <form method="POST">
        <label for="offre">Sélectionner une offre :</label>
        <select name="offre" id="offre" required>
            <?php
            foreach ($offres as $offre) {
                echo '<option value="' . $offre['offre'] . '">' . htmlspecialchars($offre['destination']) . '</option>';
            }
            ?>
        </select>
        <button type="submit">Rechercher</button>
    </form>

    <!-- Résultats de la recherche -->
    <?php if (isset($partenaires)) { ?>
        <h2>Partenaires associés à l'offre sélectionnée :</h2>
        <ul>
            <?php
            if (count($partenaires) > 0) {
                foreach ($partenaires as $partenaire) {
                    echo '<li>' . htmlspecialchars($partenaire['nom']) . ' - ' . htmlspecialchars($partenaire['email']) . '</li>';
                }
            } else {
                echo '<p>Aucun partenaire trouvé pour cette offre.</p>';
            }
            ?>
        </ul>
    <?php } ?>
</body>
</html>
