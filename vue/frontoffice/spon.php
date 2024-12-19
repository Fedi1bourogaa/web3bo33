<?php
include '../../controller/SponsorS.php';

// Instancier le contrôleur et récupérer la liste des sponsors
$sponsorS = new SponsorS();
$list = $sponsorS->listSponsors();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Sponsors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container my-5">
        <!-- En-tête de page -->
        <div class="text-center mb-5">
            <h1 class="text-primary">Liste des Sponsors</h1>
        </div>

        <!-- Affichage des sponsors sous forme de cartes -->
        <div class="row">
            <?php
            // Boucle pour afficher chaque sponsor sous forme de carte
            foreach ($list as $sponsor) {
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg sponsor-card">
                        <!-- Contenu de la carte -->
                        <div class="card-body">
                            <h5 class="card-title text-center text-uppercase"><?= htmlspecialchars($sponsor['nom']); ?></h5>
                            <p class="card-text">
                                <strong>ID Sponsor :</strong> <?= htmlspecialchars($sponsor['id_sponsor']); ?><br>
                                <strong>ID Événement :</strong> <?= htmlspecialchars($sponsor['id_eventsponsor']); ?><br>
                                <strong>Description :</strong> <?= htmlspecialchars($sponsor['description']); ?><br>
                                <strong>Numéro de Téléphone :</strong> <?= htmlspecialchars($sponsor['phone']); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- Styles pour les animations -->
    <style>
        /* Animation de la carte */
        .sponsor-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .sponsor-card:hover {
            transform: translateY(-10px); /* La carte "monte" légèrement */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3); /* Ombre plus intense */
        }

        /* Styling supplémentaire pour les cartes */
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
        }
    </style>

</body>
</html>
