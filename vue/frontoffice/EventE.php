<?php
require_once '../../config.php';
require_once '../../model/Event.php';

class EventE
{
    // Liste tous les événements
    public function listEvents()
    {
        $sql = "SELECT * FROM event";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste->fetchAll();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function deleteEvent($id_event)
    {
        $sql = "DELETE FROM event WHERE id_event = :id_event";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_event', $id_event);

        try {
            return $req->execute(); // Retourne true si la suppression est réussie
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function addEvent($event)
    {
        $sql = "INSERT INTO event (nom_event, date_event, type, image) VALUES (:nom_event, :date_event, :type, :image)";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);

            // Convertir l'objet DateTime en chaîne (format 'Y-m-d')
            $dateEventFormatted = $event->getDateEvent(); // Supposons que `getDateEvent` retourne un objet `DateTime`
            if ($dateEventFormatted instanceof DateTime) {
                $dateEventFormatted = $dateEventFormatted->format('Y-m-d');
            }

            $query->execute([
                'nom_event' => $event->getNomEvent(),
                'date_event' => $dateEventFormatted, // Utilise la date formatée
                'type' => $event->getType(),
                'image' => $event->getImage()
            ]);

            return true; // Retourne vrai si tout s'est bien passé
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
            return false; // Retourne faux en cas d'erreur
        }
    }

    // Met à jour un événement existant
    public function updateEvent($id, $nom_event, $date_event, $type, $image)
    {
        $db = config::getConnexion();
        try {
            $query = $db->prepare(
                'UPDATE event SET nom_event = :nom_event, date_event = :date_event, type = :type, image = :image WHERE id_event = :id'
            );

            // Exécuter la requête avec les valeurs passées
            $query->execute([
                'id' => $id,
                'nom_event' => $nom_event,
                'date_event' => $date_event,
                'type' => $type,
                'image' => $image
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Affiche les détails d'un événement spécifique
    public function afficherEvent($id)
    {
        $db = config::getConnexion();
        try {
            $query = $db->prepare(
                'SELECT * FROM event WHERE id_event = :id'
            );
            $query->execute(['id' => $id]);
            $result = $query->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    // Fonction de pagination
    public function getPaginatedEvents($page, $itemsPerPage)
    {
        $db = config::getConnexion();

        // Calcul de l'offset
        $offset = ($page - 1) * $itemsPerPage;

        try {
            // Récupérer les événements paginés
            $stmt = $db->prepare("SELECT * FROM event LIMIT :limit OFFSET :offset");
            $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $events = $stmt->fetchAll();

            // Récupérer le nombre total d'événements
            $totalEvents = $db->query("SELECT COUNT(*) FROM event")->fetchColumn();

            return [
                'events' => $events,
                'totalEvents' => $totalEvents
            ];
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
