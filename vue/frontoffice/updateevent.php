<?php
include '../../controller/EventE.php';
$eventE = new EventE();

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    // Récupérer l'événement
    $tab = $eventE->afficherEvent($id);

    // Vérifier si un événement a été trouvé avec cet ID
    if (count($tab) > 0) {
        $event = $tab[0]; // Récupérer le premier élément
    } else {
        echo "Événement non trouvé.";
        exit();
    }
} else {
    echo "ID manquant dans l'URL.";
    exit();
}

if (isset($_POST["update"])) {
    // Récupérer les nouvelles valeurs
    $new_nom_event = $_POST["nom_event"];
    $new_date_event = $_POST["date_event"];
    $new_type = $_POST["type"];

    // Gestion de l'image uploadée
    $new_image = $event['image']; // Valeur par défaut (ancienne image)
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifier les types autorisés
        $allowed_types = ["jpg", "png", "jpeg", "gif"];
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $new_image = $target_file;
            } else {
                echo "Erreur lors du téléchargement de l'image.";
                exit();
            }
        } else {
            echo "Seuls les formats JPG, PNG, JPEG, et GIF sont autorisés.";
            exit();
        }
    }

    // Appel à la méthode pour mettre à jour l'événement
    $eventE->updateEvent($id, $new_nom_event, $new_date_event, $new_type, $new_image);
    header("Location: listevents.php"); // Redirection après mise à jour
    exit();
}
?>











            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Modifier un Événement</title>
            </head>
            <body>
                <h1>Modifier un Événement</h1>
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="nom_event">Nom de l'événement :</label>
                    <input type="text" id="nom_event" name="nom_event" value="<?= htmlspecialchars($event['nom_event']) ?>" required><br>
            
                    <label for="date_event">Date de l'événement :</label>
                    <input type="date" id="date_event" name="date_event" value="<?= htmlspecialchars($event['date_event']) ?>" required><br>
            
                    <label for="type">Type :</label>
                    <input type="text" id="type" name="type" value="<?= htmlspecialchars($event['type']) ?>" required><br>
            
                    <label for="image">Image (laisser vide pour conserver l'image actuelle) :</label>
                    <input type="file" id="image" name="image" accept="image/*"><br>
                    <img src="<?= htmlspecialchars($event['image']) ?>" alt="Image actuelle" width="100"><br>
            
                    <button type="submit" name="update">Mettre à jour</button>
                </form>
            </body>
        
    
        
        
        

           