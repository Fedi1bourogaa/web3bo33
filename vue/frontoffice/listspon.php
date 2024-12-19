<?php
include '../../controller/SponsorS.php';

// Instancier le contrôleur et récupérer la liste des sponsors
$sponsorS = new SponsorS();
$list = $sponsorS->listSponsors();
?>
 <div class="d-flex justify-content-between">
        <h1 style="margin-top: 400px;">Liste des Sponsors</h1>


            <a href="addsponsor.php" class="btn btn-primary" style="margin-top: 500px;">Ajouter un Sponsor</a>

        </div>

        <!-- Tableau des sponsors -->
        <div class="table-responsive"style="font-size: 0.85rem;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Sponsor</th>
                        <th>ID Événement Sponsor</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Numéro de Téléphone</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Boucle pour afficher chaque sponsor dans le tableau
                    foreach ($list as $sponsor) {
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($sponsor['id_sponsor']); ?></td>
                            <td><?= htmlspecialchars($sponsor['id_eventsponsor']); ?></td>
                            <td><?= htmlspecialchars($sponsor['nom']); ?></td>
                            <td><?= htmlspecialchars($sponsor['description']); ?></td>
                            <td><?= htmlspecialchars($sponsor['phone']); ?></td>
                            <td>
                                <!-- Lien vers la page de modification du sponsor -->
                                <a href="updatesponsor.php?id=<?= $sponsor['id_sponsor']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            </td>
                            <td>
                                <!-- Lien de suppression avec confirmation -->
                                <a href="deletesponsor.php?id_sponsor=<?= htmlspecialchars($sponsor['id_sponsor']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce sponsor ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>