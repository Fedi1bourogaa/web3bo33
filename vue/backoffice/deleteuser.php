

<?php 
// Inclure le fichier de configuration pour se connecter à la base de données

include '../../controller/AdminController.php'; // Inclure le contrôleur des utilisateurs si nécessaire

// Vérifier si un ID est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = $_GET['id']; // Récupérer l'ID de l'utilisateur à supprimer

    try {
        // Utiliser un contrôleur ou une requête directe pour supprimer l'utilisateur
        $adminController = new UsersController(); // Créer une instance de UsersController
        $adminController->deleteUser($userId); // Appeler la méthode deleteUser

        // Rediriger vers la page de gestion des utilisateurs après la suppression
        header("Location: admin_manage_users.php?success=1");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
    }
} else {
    // Rediriger vers la liste si aucun ID n'est passé
    header("Location: index.php?error=1");
    exit();
}







/*include'../../controller/AdminController.php';
$controller= new UsersController();
$users=$controller->deleteUser($_GET['id']);
header('location:UtilisateurModel.php')
?>*/