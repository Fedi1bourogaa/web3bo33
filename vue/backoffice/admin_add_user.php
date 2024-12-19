<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Utilisateur | El Hadhra</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <div class="admin-container">
        <h2>Ajouter un Utilisateur</h2>
        <form action="/admin_add_user" method="POST">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="role">Rôle :</label>
            <select id="role" name="role">
                <option value="admin">Admin</option>
                <option value="contributeur">Contributeur</option>
                <option value="utilisateur">Utilisateur</option>
            </select>

            <label for="motDePasse">Mot de passe :</label>
            <input type="password" id="motDePasse" name="motDePasse" required>

            <button type="submit">Ajouter</button>
        </form>
        <a href="admin_manage_users.html">Retour à la liste des utilisateurs</a>
        
    </div>
    <script src="javab.js"></script>
</body>
</html>
