<?php
include '../../config.php'; // Fichier contenant la connexion à la base de données
include'../../model/UtilisateurModel.php'; // Modèle de l'utilisateur

class UsersController
{
    // Méthode pour lister tous les utilisateurs
    public function listUsers()
    {
        $sql = "SELECT * FROM users"; // Table correcte dans la base de données
        $db = config::getConnexion();
        try {
            $users = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC); // Récupération sous forme associative
            return $users;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function deleteUser($id) {
        try {
            $pdo = config::getConnexion();
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression : " . $e->getMessage());
        }
    }
    

    /*public function deleteUser($id)
    {
        
        $sql="DELETE FROM users WHERE id = :id;";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req -> bindValue(':id',$id);
        try
        {
            $db->prepare($sql);
            $req->execute();
            
        }catch(Exception $e)
        {
            echo 'error'. $e->getMessage();
        }

 
    }*/

    // Méthode pour supprimer un utilisateur par ID
   /* public function deleteUser($id)
    {                                                                                                                                                                                               
        $sql = "DELETE FROM users WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT); // Sécurisation avec PDO
            $query->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }*/
   /* public function deleteUser($id) {
        try {
            // Connexion à la base de données
            $db = config::getConnexion();
            
            // Préparer la requête SQL pour supprimer un utilisateur par ID
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $db->prepare($sql);
            
            // Lier l'ID de l'utilisateur
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            // Exécuter la requête
            return $stmt->execute();
        } catch (PDOException $e) {
            // En cas d'erreur, retourner false
            return false;
        }
    }*/

   

    // Méthode pour ajouter un nouvel utilisateur
    public function addUser($user)
    {
        $sql = "INSERT INTO users (nom, prenom, email, mot_de_passe, role, entreprise, secteur, site_web, telephone, adresse) 
                VALUES (:nom, :prenom, :email, :mot_de_passe, :role, :entreprise, :secteur, :site_web, :telephone, :adresse)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'email' => $user->getEmail(),
                'mot_de_passe' => password_hash($user->getMotDePasse(), PASSWORD_DEFAULT), // Hachage pour sécurité
                'role' => $user->getRole(),
                'entreprise' => $user->getEntreprise(),
                'secteur' => $user->getSecteur(),
                'site_web' => $user->getSiteWeb(),
                'telephone' => $user->getTelephone(),
                'adresse' => $user->getAdresse()
            ]);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Méthode pour mettre à jour un utilisateur par ID
    public function updateUser($users, $id)
    {
        $sql = "UPDATE users SET 
                    nom = :nom,
                    prenom = :prenom,
                    email = :email,
                    mot_de_passe = :mot_de_passe,
                    role = :role,
                    entreprise = :entreprise,
                    secteur = :secteur,
                    site_web = :site_web,
                    telephone = :telephone,
                    adresse = :adresse
                WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id' => $id,
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'email' => $user->getEmail(),
                'mot_de_passe' => password_hash($user->getMotDePasse(), PASSWORD_DEFAULT), // Hachage pour sécurité
                'role' => $user->getRole(),
                'entreprise' => $user->getEntreprise(),
                'secteur' => $user->getSecteur(),
                'site_web' => $user->getSiteWeb(),
                'telephone' => $user->getTelephone(),
                'adresse' => $user->getAdresse()
            ]);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Méthode pour récupérer un utilisateur par ID
    public function showUser($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC); // Retourne une ligne sous forme associative
            return $user;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>

































//<?php
// Inclure le modèle
/*include('UtilisateurModel.php');
include('config.php');

class AdminController {

    // Afficher le tableau de bord avec tous les utilisateurs
    public function showDashboard() {
        $users = UtilisateurModel::getAllUsers();
        include('views/admin_dashboard.php');  // Vue avec la liste des utilisateurs
    }

    // Ajouter un nouvel utilisateur
    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'];
            $role = $_POST['role'];
            $entreprise = $_POST['entreprise'] ?? null;
            $secteur = $_POST['secteur'] ?? null;
            $site_web = $_POST['site_web'] ?? null;
            $telephone = $_POST['telephone'] ?? null;
            $adresse = $_POST['adresse'] ?? null;

            // Appeler le modèle pour ajouter un utilisateur
            if (UtilisateurModel::addUser($nom, $prenom, $email, $mot_de_passe, $role, $entreprise, $secteur, $site_web, $telephone, $adresse)) {
                header("Location: admin_dashboard.php");  // Rediriger vers le tableau de bord
                exit();
            } else {
                echo "Erreur lors de l'ajout de l'utilisateur.";
            }
        } else {
            include('views/add_user_form.php');  // Afficher le formulaire d'ajout
        }
    }

    // Modifier un utilisateur existant
    public function updateUser($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $entreprise = $_POST['entreprise'] ?? null;
            $secteur = $_POST['secteur'] ?? null;
            $site_web = $_POST['site_web'] ?? null;
            $telephone = $_POST['telephone'] ?? null;
            $adresse = $_POST['adresse'] ?? null;

            // Appeler le modèle pour mettre à jour l'utilisateur
            if (UtilisateurModel::updateUser($id, $nom, $prenom, $email, $role, $entreprise, $secteur, $site_web, $telephone, $adresse)) {
                header("Location: admin_dashboard.php");  // Rediriger vers le tableau de bord
                exit();
            } else {
                echo "Erreur lors de la mise à jour de l'utilisateur.";
            }
        } else {
            // Récupérer les données de l'utilisateur à modifier
            $user = UtilisateurModel::getUserById($id);
            include('views/edit_user_form.php');  // Afficher le formulaire de modification
        }
    }

    // Supprimer un utilisateur
    public function deleteUser($id) {
        if (UtilisateurModel::deleteUser($id)) {
            header("Location: admin_dashboard.php");  // Rediriger vers le tableau de bord après la suppression
            exit();
        } else {
            echo "Erreur lors de la suppression de l'utilisateur.";
        }
    }
}
?>*/
