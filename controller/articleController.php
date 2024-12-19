<?php
include_once(__DIR__ . '/../config.php');
include_once(__DIR__ . '/../model/articles.php');
class articlesController
{
    // Méthode pour lister toutes les tâches
    public function listArticles()
    {
        $sql = "SELECT * FROM articles";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function addArticle($articles) {
        try {
            $sql = "INSERT INTO articles (titre, contenu, date_publication, categorie, rate, count_rates, image)
                    VALUES (:titre, :contenu, :date_publication, :categorie, :rate, :count_rates, :image)";
            $db = config::getConnexion(); // Méthode pour obtenir la connexion à la base de données
            $stmt = $db->prepare($sql);
            
            $stmt->bindValue(':titre', $articles->getTitre());
            $stmt->bindValue(':contenu', $articles->getContenu());
            $stmt->bindValue(':date_publication', $articles->getdate_publication());
            $stmt->bindValue(':categorie', $articles->getCategorie());
            $stmt->bindValue(':rate', $articles->getRate());
            $stmt->bindValue(':count_rates', $articles->getCountRates());
            $stmt->bindValue(':image', $articles->getImage());
    
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }
    
    
    // Méthode pour supprimer un article par son ID
    public function deleteArticles($Id)
    {
        $sql = "DELETE FROM articles WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $Id);
            $query->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    // Méthode pour mettre à jour un article
    public function updateArticle($Id, $Titre, $Contenu, $date_publication, $Categorie, $image)
    {
        $db = config::getConnexion();
        $query = $db->prepare('
            UPDATE articles
            SET titre = :titre, contenu = :contenu, date_publication = :date_publication, categorie = :categorie, image = :image
            WHERE id = :id
        ');
        $query->bindValue(':id', $Id, PDO::PARAM_INT);
        $query->bindValue(':titre', $Titre);
        $query->bindValue(':contenu', $Contenu);
        $query->bindValue(':date_publication', $date_publication);
        $query->bindValue(':categorie', $Categorie);
        $query->bindValue(':image', $image);
        $query->execute();
    }
    // Méthode pour obtenir un article par son ID
    public function getArticleById($Id)
    {
        $sql = "SELECT * FROM articles  WHERE id = :Id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':Id', $Id);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getArticlesWithSearchAndSort($search, $sort, $limit, $offset) {
        $db = config::getConnexion();
        $stmt = $db->prepare("
            SELECT * 
            FROM articles 
            WHERE titre LIKE :search OR contenu LIKE :search OR categorie LIKE :search
            ORDER BY date_publication $sort
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTotalArticlesCount($search) {
        $db = config::getConnexion();
        $stmt = $db->prepare("
            SELECT COUNT(*) as count 
            FROM articles 
            WHERE titre LIKE :search OR contenu LIKE :search OR categorie LIKE :search
        ");
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }
    // Get all articles
public function getArticles() {
    $db = config::getConnexion();
    $stmt = $db->prepare("SELECT * FROM articles");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function Rating($Id,$rate,$count_rates)
{
    $db = config::getConnexion();
    $query = $db->prepare('
        UPDATE articles
        SET rate = :rate, count_rates = :count_rates
        WHERE id = :id
    ');
    $query->bindValue(':id', $Id, PDO::PARAM_INT);
    $query->bindValue(':rate', $rate);
    $query->bindValue(':count_rates', $count_rates);
    $query->execute();
}
    
}
?>