<?php
include '../../config.php';

try {
    $pdo = config::getConnexion();

    // Comptage des utilisateurs par rôle
    $sql = "SELECT role, COUNT(*) as count FROM users GROUP BY role";
    $stmt = $pdo->query($sql);
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Total des utilisateurs
    $totalUsers = array_sum(array_column($roles, 'count'));

    // Préparer les statistiques pour l'affichage
    $stats = [
        'admin' => 0,
        'visiteur' => 0,
        'guide' => 0,
        'partenaire' => 0,
    ];

    $percentages = [
        'admin' => 0,
        'visiteur' => 0,
        'guide' => 0,
        'partenaire' => 0,
    ];

    foreach ($roles as $role) {
        $stats[$role['role']] = $role['count'];
        if ($totalUsers > 0) {
            $percentages[$role['role']] = round(($role['count'] / $totalUsers) * 100, 2);
        }
    }

    // Récupérer la liste des utilisateurs
    $sql = "SELECT id, nom, prenom, email, role FROM users";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | El Hadhra</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('tunisia-background.jpg') no-repeat center center fixed; /* Remplacez par le chemin de l'image */
            background-size: cover;
            color: #333;
            text-align: center;
        }

        .admin-container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.95); /* Fond blanc légèrement transparent */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #b71c1c;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .stats-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .stat-box {
            background-color: #000;
            color: #fff;
            width: 200px;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .stat-box strong {
            display: block;
            font-size: 24px;
            color: #b71c1c;
        }

        table {
            width: 80%;
            margin: 30px auto; /* Centre le tableau horizontalement */
            border-collapse: collapse;
            color: #000;
        }

        th, td {
            padding: 10px;
            border: 1px solid #000;
            text-align: left;
        }

        th {
            background-color: #b71c1c;
            color: #fff;
        }

        tbody tr:nth-child(even) {
            background-color: #f4f4f9;
        }

        tbody tr:hover {
            background-color: #ffe6e6;
        }

        .search-container {
            width: 50%;
            margin: 20px auto;
        }

        .search-container input {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #b71c1c;
        }

        a {
            text-decoration: none;
            color: #b71c1c;
            font-size: 18px;
            margin-top: 20px;
            display: inline-block;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<br>
<br>
<br>
    <!-- Notification de l'admin -->
<div id="notification" class="notification">
<img src="https://upload.wikimedia.org/wikipedia/commons/6/60/Font_Awesome_5_solid_bell.svg" alt="Notification" class="notification-icon" />

    <span id="notification-message" class="notification-message"></span>
</div>

<style>
.notification {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 10px 20px;
    display: none; /* La notification est cachée par défaut */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 9999;
    max-width: 400px;
    font-size: 1rem;
    color: #333;
    text-align: center;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
}

.notification-icon {
    width: 30px;
    height: 30px;
}

.notification-message {
    font-size: 1rem;
    color: #333;
}

.notification:hover {
    background-color: #f4f4f4;
}

.notification.show {
    display: flex;
    animation: slideIn 0.5s ease-in-out;
}

/* Animation pour faire apparaître la notification */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}
</style>
<script>
// Fonction pour afficher la notification avec le message personnalisé
function showNotification(username) {
    const notification = document.getElementById('notification');
    const message = document.getElementById('notification-message');
    
    // Personnaliser le message
    message.textContent = username + " a fait un rating";

    // Afficher la notification
    notification.classList.add('show');

    // Cacher la notification après 5 secondes
    setTimeout(() => {
        notification.classList.remove('show');
    }, 5000);
}

// Exemple : Vous pouvez appeler cette fonction lorsque l'utilisateur soumet son évaluation
// Par exemple :
document.getElementById('send-rating').addEventListener('click', function() {
    const username = "JohnDoe"; // Remplacez par le nom d'utilisateur réel
    showNotification(username);
});
</script>



    <div class="admin-container">
        <h2>Statistiques des Utilisateurs</h2>
        <div class="stats-container">
            <div class="stat-box">
                Administrateurs
                <strong><?= $stats['admin'] ?> (<?= $percentages['admin'] ?>%)</strong>
            </div>
            <div class="stat-box">
                Visiteurs
                <strong><?= $stats['visiteur'] ?> (<?= $percentages['visiteur'] ?>%)</strong>
            </div>
            <div class="stat-box">
                Guides
                <strong><?= $stats['guide'] ?> (<?= $percentages['guide'] ?>%)</strong>
            </div>
            <div class="stat-box">
                Partenaires
                <strong><?= $stats['partenaire'] ?> (<?= $percentages['partenaire'] ?>%)</strong>
            </div>
        </div>

        <h2>Liste des Utilisateurs</h2> 
          <!-- Ajout du lien Ajouter Admin -->
    <div style="text-align: left; margin: 10px 0;">
        <a href="addadmin.php" style="color: #b71c1c; font-weight: bold; font-size: 18px; text-decoration: underline;">+ Ajouter Admin</a>
    </div>
        <div class="search-container">
            <input type="text" id="search" placeholder="Recherchez les utilisateurs">
        </div>
        <table id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
        
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['nom']) ?></td>
                            <td><?= htmlspecialchars($user['prenom']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td>
                                <a href="admin_edit_user.php?id=<?= $user['id'] ?>">Modifier</a> |
                                <a href="deleteuser.php?id=<?= $user['id'] ?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">Aucun utilisateur inscrit.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <script>
            $(document).ready(function() {
                var table = $('#userTable').DataTable({
                    "paging": false,
                    "info": false
                });

                $('#search').on('keyup', function() {
                    var value = $(this).val();
                    console.log('Recherche déclenchée : ' + value); // Debug
                    table.search(value ? value : '').draw();
                });
            });
        </script>

        <a href="http://localhost/web3bo/vue/backoffice/admin_profile.php">
            Profil de Admin
        </a>
        <a href="http://localhost/web3bo/vue/backoffice/evaluation_site_ad.php">
           voir rating
        </a>
    </div>
</body>
</html>







<!--<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Utilisateurs | El Hadhra</title>
    <link rel="stylesheet" href="admin_styles.css">
    
</head>
<body>
    <div class="admin-container">
        <h2>Liste des Utilisateurs</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                 Exemple de données dynamiques 
                <tr>
                    //?php
            // Boucle sur la liste des objectifs pour les afficher
            foreach ($list as $objectif) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($objectif['nom']) . "</td>";
                echo "<td>" . htmlspecialchars($objectif['prenom']) . "</td>";
                echo "<td>" . htmlspecialchars($objectif['email']) . "</td>";
                echo "<td>" . htmlspecialchars($objectif['role']) . "</td>";
                echo "<td>" . htmlspecialchars($objectif['mot_de_passe']) . "</td>";
                echo "<td>" . htmlspecialchars($objectif['statut']) . "</td>";
                echo "<td>
                <a href='showObjectif.php?id=" . $objectif['id'] . "'>Voir Détails</a>
                <a href='deleteObjectif.php?id=" . $objectif['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet objectif ?\")'>Supprimer</a>
                </td>";
                echo "</tr>";
            }
            ?>
                        <a href="admin_edit_user.html?id=1">Modifier</a> |
                        <a href="admin_delete_user.html?id=1">Supprimer</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <a href="admin_dashboard.html">Retour au Tableau de Bord</a>
        <script src="scriptb.js"></script>
    </div>
    <script src="javab.js"></script>
</body>
</html>-->
