<?php
include_once(__DIR__ . '/../config.php');
include_once(__DIR__ . '/../model/commentaire.php');
class commentaireController
{
    // Méthode pour lister tous les testimonials
    public function listeCommentaire()
    {
        $sql = "SELECT * FROM commentaires";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    // Méthode pour ajouter un nouvel commentaire
    public function addCommentaire($commentaires)
    {
        $sql = "INSERT INTO articles (Nom,Contenu_Comm, Date_pub)
                VALUES ( :Nom, :Contenu_Comm, :Date_pub)";
        $db = config::getConnexion();
        $stmt = $db->prepare($sql);
        try {
            $query = $db->prepare($sql);
            $query->execute([
                $stmt->bindValue(':Nom', $commentaires->getNom()),
                $stmt->bindValue(':Contenu_Comm', $commentaires->getContenu_Comm()),
                $stmt->bindValue(':Date_pub', $commentaires->getDate_pub())
            ]);
            } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    // Méthode pour supprimer un commentaire par son ID
    public function deleteCommentaire($Id_commentaire)
    {
        $sql = "DELETE FROM commentaires WHERE id = :Id_commentaire";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':Id_commentaire', $Id_commentaire);
            $query->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
//commentaire par ID
    public function getCommentairesById($Id_commentaire) {
        $sql = "SELECT * FROM commentaires  WHERE Id_commentaire = :Id_commentaire";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':Id_commentaire', $Id_commentaire);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    
    // Méthode pour mettre à jour un commentaire
    public function updateCommentaire($Id_commentaire, $Nom, $Contenu_Comm, $Date_pub) {
        $db = config::getConnexion();
        $query = $db->prepare('
            UPDATE commentaires
            SET Nom = :Nom, Contenu_Comm = :Contenu_Comm, Date_pub = :Date_pub 
            WHERE Id_commentaire = :Id_commentaire
        ');
        $query->bindValue(':Id_commentaire', $Id_commentaire, PDO::PARAM_INT);
        $query->bindValue(':Nom', $Nom);
        $query->bindValue(':Contenu_Comm', $Contenu_Comm);
        $query->bindValue(':Date_pub', $Date_pub);
        $query->execute();
    }
    
    public function getCommentById($Id_commentaire) {
        $sql = "SELECT Nom,Contenu_Comm FROM commentaires WHERE Id_commentaire = :Id_commentaire";
        $db = Config::getConnexion();
        $query = $db->prepare($sql);
        $query->execute(['Id_commentaire' => $Id_commentaire]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCommentaireByArticleId($Id) {
        $sql = "SELECT * FROM commentaires WHERE Id_commentaire = :Id";
        $db = config::getConnexion();
        $query = $db->prepare($sql);
        $query->bindValue(':Id', $Id,PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }
    public function getCommentairesWithPagination($limit, $offset) {
        $db = config::getConnexion();
        $stmt = $db->prepare("
            SELECT 
                commentaires.id, 
                commentaires.nom, 
                commentaires.contenu_comm, 
                commentaires.date_pub, 
                articles.titre as article_name
            FROM commentaires
            JOIN articles ON commentaires.id_article = articles.id
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTotalCommentairesCount() {
        $db = config::getConnexion();
        $stmt = $db->query("SELECT COUNT(*) as count FROM commentaires");
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }
    // Fetch comments for an article
public function getCommentsByArticle($articleId) {
    $db = config::getConnexion();
    $stmt = $db->prepare("SELECT * FROM commentaires WHERE id_article = :id_article");
    $stmt->bindValue(':id_article', $articleId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Add a comment
public function addComment($name, $content, $articleId) {
    $db = config::getConnexion();
    $stmt = $db->prepare("INSERT INTO commentaires (nom, contenu_comm, date_pub, id_article) VALUES (:nom, :contenu_comm, NOW(), :id_article)");
    $stmt->bindValue(':nom', $name, PDO::PARAM_STR);
    $stmt->bindValue(':contenu_comm', $content, PDO::PARAM_STR);
    $stmt->bindValue(':id_article', $articleId, PDO::PARAM_INT);
    $stmt->execute();
}
// Delete a comment
public function deleteComment($id) {
    $db = config::getConnexion();
    $stmt = $db->prepare("DELETE FROM commentaires WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
// Update a comment
public function updateComment($id, $content) {
    $db = config::getConnexion();
    $stmt = $db->prepare("UPDATE commentaires SET contenu_comm = :contenu_comm, date_pub = NOW() WHERE id = :id");
    $stmt->bindValue(':contenu_comm', $content, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
   
}
?>