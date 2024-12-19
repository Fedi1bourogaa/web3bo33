<?php
session_start();
require_once '../../Controller/CommandeController.php';
require_once '../../Model/Commande.php';

$commandeC = new CommandeController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["nom_prenom"], $_POST["num_tlf"], $_POST["location"], $_POST["id_produit"], $_POST["prixtot"])) {
        $nom_prenom = trim($_POST['nom_prenom']);
        $num_tlf = trim($_POST['num_tlf']);
        $location = trim($_POST['location']);
        $id_produit = trim($_POST['id_produit']);
        $prixtot = trim($_POST['prixtot']);

        // Récupérer l'ID de l'utilisateur connecté
        $user_id = $_SESSION['user_id'];

        // Validation des champs
        if (
            strlen($nom_prenom) >= 5 && preg_match('/^[A-Za-z\s]+$/', $nom_prenom) &&
            preg_match('/^\d{8}$/', $num_tlf) && strlen($location) >= 5 &&
            is_numeric($id_produit) && intval($id_produit) > 0 &&
            is_numeric($prixtot) && floatval($prixtot) > 0
        ) {
            // Créer un objet Commande
            $commande = new Commande($nom_prenom, $num_tlf, $location, intval($id_produit), floatval($prixtot));

            try {
                // Ajouter la commande avec l'ID utilisateur
                $commandeC->addCommande($commande, $user_id);

                // Supprimer le produit du panier
                unset($_SESSION['cart'][$id_produit]);

                header('Location: index.php?success=1');
                exit;
            } catch (Exception $e) {
                $errorMessage = "Erreur lors de l'ajout de la commande : " . $e->getMessage();
            }
        } else {
            $errorMessage = "Veuillez remplir correctement tous les champs.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acheter un Produit</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styles globaux */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0 auto;
        }

        .product-detail {
            background-color: #fff;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            display: flex;
            width: 80%;
            max-width: 1200px;
            padding: 20px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .product-detail:hover {
            transform: scale(1.03);
        }

        .product-info {
            flex: 1;
            margin-right: 20px;
            position: relative;
        }

        .product-img {
            width: 100%;
            height: auto;
            max-height: 350px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .product-text {
            margin-top: 15px;
        }

        .product-name {
            font-size: 28px;
            font-weight: 500;
            color: #444;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .product-description {
            font-size: 16px;
            color: #777;
            margin-bottom: 25px;
        }

        .product-price {
            font-size: 24px;
            font-weight: 600;
            color: #e91e63;
        }

        /* Formulaire d'achat */
        .purchase-form {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .purchase-form h3 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            color: #444;
            margin-bottom: 8px;
            display: block;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-top: 5px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #e91e63;
            outline: none;
        }

        .submit-btn {
            padding: 15px;
            background-color: #e91e63;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 15px;
        }

        .submit-btn:hover {
            background-color: #c2185b;
        }

        /* Messages de succès ou d'erreur */
        .success-message,
        .error-message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 600;
        }

        .success-message {
            background-color: #4caf50;
            color: #fff;
        }

        .error-message {
            background-color: #f44336;
            color: #fff;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .product-detail {
                flex-direction: column;
                max-width: 100%;
            }

            .product-info {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .product-img {
                max-height: 250px;
            }

            .annuler-btn {
                padding: 15px;
                background-color: #e91e63;
                /* Red background color */
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 18px;
                cursor: pointer;
                transition: background-color 0.3s;
                margin-top: 15px;
            }

            .annuler-btn:hover {
                background-color: #c2185b;
            }
        }
    </style>
</head>

<body>
    <?php
    foreach ($_SESSION['cart'] as $produit) {
    ?>
        <div class="container">
            <div class="product-detail">
                <!-- Détail du produit -->
                <div class="product-info">
                    <img src="data:image/png;base64,<?= base64_encode($produit['image']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>" class="product-img">
                    <div class="product-text">
                        <h2 class="product-name"><?php echo htmlspecialchars($produit['nom']); ?></h2>
                        <p class="product-description"><?php echo htmlspecialchars($produit['description']); ?></p>
                        <p class="product-price"><?php echo htmlspecialchars($produit['prix']); ?> DT</p>
                        <p class="product-description">Quantité : <?php echo htmlspecialchars($produit['quantity']); ?></p>
                    </div>
                </div>

                <!-- Formulaire d'achat -->
                <div class="purchase-form">
                    <h3>Formulaire d'Achat</h3>

                    <!-- Messages de succès ou d'erreur -->
                    <?php if (!empty($successMessage)) { ?>
                        <div class="success-message"><?php echo $successMessage; ?></div>
                    <?php } elseif (!empty($errorMessage)) { ?>
                        <div class="error-message"><?php echo $errorMessage; ?></div>
                    <?php } ?>

                    <form action="AcheterProduit.php?id=<?php echo $produit['id']; ?>" method="POST" onsubmit="return validateForm()">
                        <input type="hidden" name="id_produit" value="<?php echo $produit['id']; ?>">
                        <input type="hidden" name="prixtot" value="<?php echo $produit['prix'] * $produit['quantity']; ?>">
                        <div class="form-group">
                            <label for="nom_prenom">Nom et Prénom :</label>
                            <input type="text" id="nom_prenom" name="nom_prenom">
                        </div>

                        <div class="form-group">
                            <label for="num_tlf">Numéro de Téléphone :</label>
                            <input type="text" id="num_tlf" name="num_tlf">
                        </div>

                        <div class="form-group">
                            <label for="location">Adresse :</label>
                            <input type="text" id="location" name="location">
                        </div>

                        <button type="submit" class="submit-btn">Acheter Maintenant</button>
                    </form>
                    <div class="purchase-form">
                        <a href="deleteProductCart.php?id=<?php echo $produit['id']; ?>" class="submit-btn" style="width: 157px;background-color:red;" >Annuler</a>
                    </div>
                    <script>
                        function validateForm() {
                            // Récupère les valeurs des champs
                            const nomPrenom = document.getElementById('nom_prenom').value.trim();
                            const numTlf = document.getElementById('num_tlf').value.trim();
                            const location = document.getElementById('location').value.trim();

                            // Vérification du nom et prénom
                            if (nomPrenom.length < 5) {
                                alert("Le nom et prénom doivent contenir au moins 5 caractères.");
                                return false; // Empêche l'envoi du formulaire
                            }
                            if (!/^[A-Za-z\s]+$/.test(nomPrenom)) {
                                alert("Le nom et prénom doivent contenir uniquement des lettres et des espaces.");
                                return false; // Empêche l'envoi du formulaire
                            }

                            // Vérification du numéro de téléphone
                            if (!/^\d{8}$/.test(numTlf)) {
                                alert("Le numéro de téléphone doit être composé de 8 chiffres.");
                                return false; // Empêche l'envoi du formulaire
                            }

                            // Vérification de l'adresse
                            if (location.length < 5) {
                                alert("L'adresse doit contenir au moins 5 caractères.");
                                return false; // Empêche l'envoi du formulaire
                            }

                            // Confirmation de l'achat
                            const confirmation = confirm("Êtes-vous sûr de vouloir acheter ce produit ?");
                            return confirmation; // Si l'utilisateur confirme, le formulaire est envoyé
                        }
                    </script>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</body>

</html>
