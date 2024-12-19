<?php
require_once __DIR__ . '/../../../Controller/CommandeController.php';
require_once __DIR__ . '/../../../Controller/ProduitsController.php';

$Pc = new ProduitsController();
$Cc = new CommandeController();

// Vérifiez que l'ID est passé par GET
if (isset($_GET['ID_commande'])) {
    $commande = $Cc->getCommandeById($_GET['ID_commande']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['nom_prenom'], $_POST['num_tlf'], $_POST['location'], $_POST['id_produit']) &&
        !empty($_POST['nom_prenom']) && !empty($_POST['num_tlf']) && !empty($_POST['location']) && !empty($_POST['id_produit'])
    ) {
        // Création d'une commande avec les données du formulaire
        $commande = new Commande(
            $_POST['nom_prenom'],
            $_POST['num_tlf'],
            $_POST['location'],
            $_POST['id_produit'],0
        );

        // Mise à jour de la commande
        $updated = $Cc->updateCommande($commande, $_GET['ID_commande']);

        if ($updated) {
            header('Location: tables.php'); // Rediriger vers la page des commandes
            exit;
        } else {
            echo "Aucune mise à jour n'a été effectuée.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Commande</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <?php
            if (isset($_GET['ID_commande'])) {
                $commande = $Cc->getCommandeById($_GET['ID_commande']);
            ?>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h1>Mise à Jour De Commande</h1>
                        </div>
                        <div class="card-body">
                            <form method="POST" onsubmit="return validateForm()">
                                <div class="form-group">
                                    <label for="nom_prenom">Nom et Prénom :</label>
                                    <input type="text" id="nom_prenom" name="nom_prenom" class="form-control" value="<?php echo $commande['nom_prenom']; ?>" >
                                </div>

                                <div class="form-group">
                                    <label for="num_tlf">Numéro de Téléphone :</label>
                                    <input type="number" id="num_tlf" name="num_tlf" class="form-control" value="<?php echo $commande['num_tlf']; ?>" >
                                </div>

                                <div class="form-group">
                                    <label for="location">Adresse :</label>
                                    <input type="text" id="location" name="location" class="form-control" value="<?php echo $commande['location']; ?>" >
                                </div>

                                <div class="form-group">
                                    <label for="id_produit">Produit :</label>
                                    <select id="id_produit" name="id_produit" class="form-control" >
                                        <?php
                                        $produits = $Pc->listProduit();
                                        foreach ($produits as $produit):
                                        ?>
                                            <option value="<?php echo $produit['produit_id']; ?>" <?php if ($commande['id_produit'] == $produit['produit_id']) echo "selected"; ?>>
                                                <?php echo $produit['nom']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Conteneur pour afficher les erreurs -->
                                <div id="errorMessage" style="color: red; font-weight: bold;"></div>

                                <button type="submit" class="btn btn-success btn-block">Mettre à Jour</button>
                            </form>

                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <script >


function validateForm() {
    const errorMessage = document.getElementById('errorMessage'); // Conteneur pour les erreurs
    errorMessage.innerHTML = ''; // Réinitialiser les messages d'erreur

    const nomPrenom = document.getElementById('nom_prenom').value.trim();
    const numTlf = document.getElementById('num_tlf').value.trim();
    const location = document.getElementById('location').value.trim();
    const produit = document.getElementById('id_produit').value;

    let errors = []; // Tableau pour stocker les erreurs

    // Vérifie que le nom et prénom contiennent uniquement des lettres et des espaces
    if (nomPrenom.length <= 5) {
    errors.push("Le nom et prénom doivent comporter plus de 5 caractères.");
}

    // Vérifie que le numéro de téléphone est composé exactement de 8 chiffres
    if (!/^\d{8}$/.test(numTlf)) {
        errors.push("Le numéro de téléphone doit être composé exactement de 8 chiffres.");
    }

    // Vérifie que l'adresse est bien renseignée (au moins 5 caractères)
    if (location.length < 5) {
        errors.push("L'adresse doit contenir au moins 5 caractères.");
    }

    // Vérifie qu'un produit est sélectionné
    if (!produit) {
        errors.push("Veuillez sélectionner un produit.");
    }

    // Si des erreurs existent, on les affiche dans le conteneur d'erreur
    if (errors.length > 0) {
        errorMessage.innerHTML = "<ul>"; // Démarre la liste des erreurs
        errors.forEach(function(error) {
            errorMessage.innerHTML += "<li>" + error + "</li>"; // Ajoute chaque erreur dans la liste
        });
        errorMessage.innerHTML += "</ul>"; // Ferme la liste
        return false; // Empêche l'envoi du formulaire
    }

    return true; // Le formulaire est valide
}


    </script>
    <script src="./js/controleproduits.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>