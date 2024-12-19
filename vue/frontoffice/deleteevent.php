<?php
include '../../controller/EventE.php';

if (isset($_GET['id_event']) && !empty($_GET['id_event'])) {
    $id_event = $_GET['id_event'];
    $eventE = new EventE();

    // Appel de la méthode pour supprimer l'événement
    if ($eventE->deleteEvent($id_event)) {
        header('Location: listevents.php'); // Redirige vers la liste en cas de succès
        exit();
    } else {
        echo 'Erreur lors de la suppression de l\'événement. L\'événement avec ID ' . htmlspecialchars($id_event) . ' n\'a pas été trouvé ou une erreur SQL s\'est produite.';
    }
} else {
    echo 'ID invalide spécifié pour la suppression.';
}
?>
