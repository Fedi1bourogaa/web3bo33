<?php
// Inclure db.php en utilisant __DIR__
include_once __DIR__ . '/../db.php';

// Inclure Commande.php en utilisant __DIR__
require_once __DIR__ . '/../Model/Commande.php';

class CommandeController{

    public function listcommande()
    {
        $sql = "SELECT * FROM commande";
        $db = connexion::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            $produits = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($produits)) {
                echo "Aucun produit trouvé.";
            }
            
            return $produits;
        } catch (Exception $e) {
            echo 'Erreur lors de la récupération des COMMANDES : ' . $e->getMessage();
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }
    function deleteCommande($id_commande)
    {
        $sql = "DELETE FROM commande WHERE id_commande = :id_commande";
        $db = connexion::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_commande', $id_commande);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function getCommandeById($id_commande)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM commande WHERE id_commande = :id_commande");
            $query->execute(['id_commande' => $id_commande]);
            return $query->fetch();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
       

    public function updateCommande($commande, $id_commande) {
        try {
            $db = connexion::getConnexion();
    
            // Requête SQL pour mettre à jour la commande
            $sql = 'UPDATE commande SET 
                        nom_prenom = :nom_prenom, 
                        num_tlf = :num_tlf,
                        location = :location,
                        prixTot = :prixTot,
                        id_produit = :id_produit 
                    WHERE id_commande = :id_commande';
    
            // Paramètres pour la requête SQL
            $params = [
                'nom_prenom' => $commande->getNomPrenom(),
                'num_tlf' => $commande->getNumTlf(),
                'location' => $commande->getLocation(),
                'prixTot' => $commande->getPrixTot(),
                'id_produit' => $commande->getIdProduit(),
                'id_commande' => $id_commande  // Paramètre pour l'ID de la commande à mettre à jour
            ];
    
            // Préparation et exécution de la requête
            $query = $db->prepare($sql);
            $query->execute($params);
    
            // Vérifier si des lignes ont été affectées (mise à jour réussie)
            if ($query->rowCount() > 0) {
                return true;  // Mise à jour réussie
            } else {
                return false;  // Aucun changement effectué
            }
        } catch (PDOException $e) {
            die('Erreur PDO : ' . $e->getMessage());
        }
    }
    


    function addCommande($commande, $user_id)
    {
        $sql = "INSERT INTO commande (nom_prenom, num_tlf, location, id_produit, prixTot, user_id) 
                VALUES (:nom_prenom, :num_tlf, :location, :id_produit, :prixTot, :user_id)";
        $db = connexion::getConnexion();
    
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom_prenom' => $commande->getNomPrenom(),
                'num_tlf' => $commande->getNumTlf(),
                'location' => $commande->getLocation(),
                'prixTot' => $commande->getPrixTot(),
                'id_produit' => $commande->getIdProduit(),
                'user_id' => $user_id // Associer l'ID utilisateur
            ]);
    
            echo "Commande ajoutée avec succès.";
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }
    
function RecupererProduits($id_produit){
    $sql="SELECT * from produits where id_produit=$id_produit";
    $db = Connexion::getConnexion();
    try{
        $query=$db->prepare($sql);
        $query->execute();

        $offre=$query->fetch();
        return $offre;
    }
    catch (Exception $e){
        die('Erreur: '.$e->getMessage());
    }
}
public function countCommandesWithSearch($search)
{
    $sql = "SELECT COUNT(*) AS total FROM commande WHERE 
            nom_prenom LIKE :search OR 
            num_tlf LIKE :search OR 
            location LIKE :search";
    $db = Connexion::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC)['total'];
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

public function fetchFilteredSortedCommandes($search, $sort, $limit, $offset)
{
    $sql = "SELECT * FROM commande WHERE 
        nom_prenom LIKE :search OR 
        num_tlf LIKE :search OR 
        location LIKE :search
        ORDER BY nom_prenom $sort
        LIMIT :limit OFFSET :offset";

    $db = Connexion::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $query->bindValue(':offset', (int)$offset, PDO::PARAM_INT);        
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}


}










?>