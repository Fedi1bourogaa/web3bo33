<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../Model/Categories.php';
class CategoriesController
{

    public function listCategorie()
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM CATEGORIES");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getCategorieById($id)
    {
        try {
            $pdo = connexion::getConnexion();

            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("SELECT * FROM CATEGORIES WHERE categorie_id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    function addCategorie($categorie)
    {
        $sql = "INSERT INTO CATEGORIES (nom, description) VALUES (:nom, :description)";  
        $db = connexion::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $categorie->getNom(),
                'description' => $categorie->getDescription()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    function deleteCategorie($id)
    {
        $sql = "DELETE FROM CATEGORIES WHERE categorie_id = :id";
        $db = connexion::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
    function updateCategorie($categorie, $id)
    {   
        try {
            $db = connexion::getConnexion();
            $query = $db->prepare(
                'UPDATE CATEGORIES SET 
                    nom = :nom, 
                    description = :description
                WHERE categorie_id = :id'
            );
            $query->execute([
                'id' => $id,
                'nom' => $categorie->getNom(),
                'description' => $categorie->getDescription()
            ]);
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    function selectProductsByCategory($id)
    {
        try {
            $pdo = connexion::getConnexion();
    
            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("
                SELECT p.*, c.nom AS category_name 
                FROM PRODUITS p
                INNER JOIN CATEGORIES c ON p.categorie_id = c.categorie_id
                WHERE p.categorie_id = :id
            ");
            $query->execute(['id' => $id]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    // nombre total de categories
    public function countCategoriesWithSearch($search)
{
    $sql = "SELECT COUNT(*) AS total FROM categories WHERE 
            nom LIKE :search OR 
            description LIKE :search";
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
// mztize pour filtrage 
public function fetchFilteredSortedCategories($search, $sort, $limit, $offset)
{
    $sql = "SELECT * FROM categories WHERE 
        nom LIKE :search OR 
        description LIKE :search
        ORDER BY nom $sort
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
