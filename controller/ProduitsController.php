<?php

include_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../Model/Produits.php';
class ProduitsController
{

    public function listProduit()
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM produits");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getProduitById($id)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM PRODUITS WHERE produit_id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    function addProduit($produit)
    {
        $sql = "INSERT INTO PRODUITS (nom, description, prix, stock, date_ajout, categorie_id, image) VALUES (:nom, :description, :prix, :stock, :date_ajout, :categorie_id , :image)";  
        $db = connexion::getConnexion();
        try {
            $formattedDate = $produit->getDateAjout()->format('Y-m-d');
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $produit->getNom(),
                'description' => $produit->getDescription(),
                'prix' => $produit->getPrix(),
                'stock' => $produit->getStock(),
                'date_ajout' => $formattedDate,
                'categorie_id' => $produit->getCategorieId(),
                'image' => $produit->getImage()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    function deleteProduit($id)
    {
        $sql = "DELETE FROM PRODUITS WHERE produit_id = :id";
        $db = connexion::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
    function updateProduit($produit, $id)
    {   
        try {
            $db = connexion::getConnexion();
            $sql = 'UPDATE PRODUITS SET 
                        nom = :nom, 
                        prix = :prix, 
                        description = :description,
                        stock = :stock, 
                        date_ajout = :date_ajout';
            $params = [
                'nom' => $produit->getNom(),
                'prix' => $produit->getPrix(),
                'description' => $produit->getDescription(),
                'stock' => $produit->getStock(),
                'date_ajout' => $produit->getDateAjout()->format('Y-m-d'),
                'id' => $id
            ];
            if ($produit->getImage() !== null) {
                $sql .= ', image = :image';
                $params['image'] = $produit->getImage();
            }
            if ($produit->getCategorieId() !== -1) {
                $sql .= ', categorie_id = :categorie_id';
                $params['categorie_id'] = $produit->getCategorieId();
            }
            $sql .= ' WHERE produit_id = :id';
            $query = $db->prepare($sql);
            $query->execute($params);
            echo $query->rowCount() . " record(s) UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function countProduitsWithSearch($search)
    {
        $sql = "SELECT COUNT(*) AS total FROM produits WHERE 
                nom LIKE :search OR 
                description LIKE :search OR
                prix LIKE :search OR
                stock LIKE :search OR
                date_ajout LIKE :search";
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
    
    public function fetchFilteredSortedProduits($search, $sort, $limit, $offset)
    {
        $sql = "SELECT * FROM produits WHERE 
            nom LIKE :search OR 
            description LIKE :search OR
            prix LIKE :search OR
            stock LIKE :search OR
            date_ajout LIKE :search
            ORDER BY date_ajout $sort
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
