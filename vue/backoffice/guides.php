<?php
session_start();

// Redirection si l'utilisateur n'est pas connecté
/*if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}*/

// Connexion à la base de données
$host = "localhost";
$dbname = "elhadhra";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération des utilisateurs ayant le rôle "guide"
$sql = "SELECT id, nom, prenom, email, role FROM users WHERE role = 'guide'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$guides = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si une suppression est demandée
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $emailToDelete = $_GET['delete'];

    $deleteSql = "DELETE FROM users WHERE email = :email";
    $deleteStmt = $pdo->prepare($deleteSql);
    $deleteStmt->bindParam(':email', $emailToDelete, PDO::PARAM_STR);

    if ($deleteStmt->execute()) {
        header("Location: dashboard.php?message=deleted");
        exit();
    } else {
        echo "Erreur lors de la suppression.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau des Guides</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Assuming you put the CSS in a separate file -->
</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo">KaiAdmin</div>
        <div class="user-info">
            <img src="profile.jpg" alt="Profile Picture">
            <span>Hi, User</span>
        </div>
    </header>

    <main>
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php">Partenaires</a></li>
                <li><a href="guides.php">Guides</a></li>
                
            </ul>
        </div>

        <!-- Content -->
        <div class="content">
            

            <!-- Message de succès pour la suppression -->
            <?php if (isset($_GET['message']) && $_GET['message'] === 'deleted'): ?>
                <p class="success">Guide supprimé avec succès.</p>
            <?php endif; ?>

            <h2>Liste des Guides</h2>
            <table id="example" class="display">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($guides as $guide): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($guide['nom']); ?></td>
                            <td><?php echo htmlspecialchars($guide['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($guide['email']); ?></td>
                            <td><?php echo htmlspecialchars($guide['role']); ?></td>
                            <td>
                                <!-- Formulaire pour supprimer un guide -->
                                <form action="dashboard.php" method="get" style="display: inline;">
                                    <input type="hidden" name="delete" value="<?php echo htmlspecialchars($guide['email']); ?>">
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

</body>
</html>
