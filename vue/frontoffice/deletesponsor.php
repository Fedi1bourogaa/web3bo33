<?php
include '../../controller/SponsorS.php';

if (isset($_GET['id_sponsor']) && !empty($_GET['id_sponsor'])) {
    $id_sponsor = $_GET['id_sponsor'];
    $sponsorS = new SponsorS();

    // Appel de la méthode pour supprimer le sponsor
    if ($sponsorS->deleteSponsor($id_sponsor)) {
        header('Location: listsponsor.php'); // Redirige vers la liste en cas de succès
        exit();
    } else {
        echo 'Erreur lors de la suppression du sponsor. Le sponsor avec ID ' . htmlspecialchars($id_sponsor) . ' n\'a pas été trouvé ou une erreur SQL s\'est produite.';
    }
} else {
    echo 'ID invalide spécifié pour la suppression.';
}
?>
