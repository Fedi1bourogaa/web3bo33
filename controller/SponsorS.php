<?php
// Gestion des sponsors

require_once '../../config.php';
require_once '../../model/Sponsor.php';

class SponsorS
{
    // Liste tous les sponsors
    public function listSponsors()
    {
        $sql = "SELECT * FROM sponsor";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste->fetchAll();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Supprime un sponsor par ID
    public function deleteSponsor($id_sponsor)
    {
        $sql = "DELETE FROM sponsor WHERE id_sponsor = :id_sponsor";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_sponsor', $id_sponsor);

        try {
            return $req->execute(); // Retourne true si la suppression est réussie
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Ajoute un sponsor
    public function addSponsor($sponsor)
    {
        $sql = "INSERT INTO sponsor (id_eventsponsor, nom, description, phone) VALUES (:id_eventsponsor, :nom, :description, :phone)";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);

            $query->execute([
                'id_eventsponsor' => $sponsor->getIdEventSponsor(),
                'nom' => $sponsor->getNom(),
                'description' => $sponsor->getDescription(),
                'phone' => $sponsor->getPhone()
            ]);

            return true; // Retourne vrai si tout s'est bien passé
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
            return false; // Retourne faux en cas d'erreur
        }
    }


    // Récupérer seulement les id_event de la table event
public function listEvents()
{
    $sql = "SELECT id_event FROM event"; // Sélectionne seulement les id_event
    $db = config::getConnexion();
    try {
        $liste = $db->query($sql);
        return $liste->fetchAll();
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

    public function updateSponsor($id_sponsor, $id_eventsponsor, $nom, $description, $phone)
    {
        $db = config::getConnexion();
        try {
            // Préparer la requête SQL de mise à jour
            $query = $db->prepare(
                'UPDATE sponsor 
                SET id_eventsponsor = :id_eventsponsor, 
                    nom = :nom, 
                    description = :description, 
                    phone = :phone 
                WHERE id_sponsor = :id_sponsor'
            );
    
            // Exécuter la requête avec les valeurs passées
            $query->execute([
                'id_sponsor' => $id_sponsor,
                'id_eventsponsor' => $id_eventsponsor,
                'nom' => $nom,
                'description' => $description,
                'phone' => $phone
            ]);
        } catch (PDOException $e) {
            // Afficher l'erreur en cas d'échec
            echo $e->getMessage();
        }
    }
    

    // Affiche les détails d'un sponsor spécifique
    public function afficherSponsor($id)
    {
        $db = config::getConnexion();
        try {
            $query = $db->prepare(
                'SELECT * FROM sponsor WHERE id_sponsor = :id'
            );
            $query->execute(['id' => $id]);
            $result = $query->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    public function getSponsorsCountPerEvent()
    {
        $db = Config::getConnexion();
        $sql = "SELECT 
                    e.nom_event AS event_name, 
                    e.date_event AS event_date, 
                    e.type AS event_type, 
                    COUNT(s.id_sponsor) AS sponsor_count 
                FROM sponsor s 
                INNER JOIN event e ON s.id_eventsponsor = e.id_event 
                GROUP BY e.nom_event, e.date_event, e.type";
    
        try {
            $stmt = $db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    

}
