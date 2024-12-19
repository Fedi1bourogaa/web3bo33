<?php
// Include the articles controller
include 'C:/xampp/htdocs/projet/controller/articleController.php';
// Instantiate the controller
$Pc = new articlesController();
// Check if an article ID is provided
if (isset($_GET['id'])) {
    $articleId = $_GET['id'];
    $article = $Pc->getArticleById($articleId);
    if (!$article) {
        echo "Article not found!";
        exit;
    }
} else {
    echo "No article ID provided!";
    exit;
}
// Handle the form submission
if (
    isset($_POST['Titre'], $_POST['Contenu'], $_POST['date_publication'], $_POST['Categorie'])
) {
    if (
        !empty($_POST['Titre']) &&
        !empty($_POST['Contenu']) &&
        !empty($_POST['date_publication']) &&
        !empty($_POST['Categorie'])
    ) {
        $article_image = $_FILES["file"];
        $img_name = $_FILES['file']['name'];
        $img_size = $_FILES['file']['size'];
        $tmp_name = $_FILES['file']['tmp_name'];
        $error = $_FILES['file']['error'];
        if ($error === 0) {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
    
            $allowed_exs = array("jpg", "jpeg", "png", "gif"); 
    
            if (in_array($img_ex_lc, $allowed_exs)) 
            {
                $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                $img_upload_path = '../uploads/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
    
                
            }
        }
        try {
            $Pc->updateArticle($articleId, $_POST['Titre'],$_POST['Contenu'],$_POST['date_publication'],$_POST['Categorie'],$new_img_name);
            header("Location: articles.php");
            exit;
        } catch (Exception $e) {
            echo "Error updating article: " . $e->getMessage();
        }
    } else {
        echo "All fields are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<style>
    /* Reusing styles from the original page */
    body {
        font-family: 'Quicksand', sans-serif;
        margin: 0;
        padding: 0;
        position: relative;
    }
    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("assets/img/form.png");
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        opacity: 0.5;
        z-index: -1;
    }
    .sidebar {
        width: 250px;
        background-color: #e4dcb2;
        color: black;
        position: fixed;
        height: 100%;
        padding-top: 20px;
    }
    .sidebar a {
        color: black;
        text-decoration: none;
        display: block;
        padding: 10px 20px;
        font-size: 17px;
        font-family: Arial, sans-serif;
        font-weight: bold;
    }
    .sidebar a:hover {
        background-color: #fafad2;
        color: red;
    }
    .wrapper {
        display: flex;
        min-height: 100vh;
    }
    .main-panel {
        margin-left: 250px;
        padding: 20px;
        flex: 1;
    }
    .form-control {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.01);
    }
    button {
        width: 50%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #070606;
        border-radius: 10px;
        background-color: #bd2b2b;
        color: white;
        cursor: pointer;
        text-align: center;
    }
    button:hover {
        background-color: rgb(183, 20, 20);
        transform: scale(1.05);
        text-align: center;
    }
</style>
<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <a href="index.html">
                <img src="assets/tounes.png" alt="Logo" height="100">
                <h2 style="color: rgb(183, 20, 20);">EL HADHRA.</h2>
            </a>
        </div>
        <a href="articles.php"><i class="fas fa-home"></i>Articles</a>
        <a href="commentaires.php"><i class="fas fa-layer-group"></i>Commentaires</a>
    </div>
    <!-- Main Panel -->
    <div class="main-panel">
        <div id="edit-article" class="section active">
            <h1>Edit Article</h1>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                    <form method="POST" action="" onsubmit="return validateForm();" enctype="multipart/form-data">
    <!-- Title -->
    <div class="form-group">
        <label for="Titre">Title:</label>
        <input type="text" id="Titre" name="Titre" class="form-control" value="<?= htmlspecialchars($article['titre']); ?>">
        <small id="TitreError" class="text-danger" style="display:none;">Title is required.</small>
    </div>
    <!-- Content -->
    <div class="form-group">
        <label for="Contenu">Content:</label>
        <textarea id="Contenu" name="Contenu" class="form-control"><?= htmlspecialchars($article['contenu']); ?></textarea>
        <small id="ContenuError" class="text-danger" style="display:none;">Content is required.</small>
    </div>
    <!-- Publication Date -->
    <div class="form-group">
        <label for="date_publication">Date Publication:</label>
        <input type="date" id="date_publication" name="date_publication" class="form-control" value="<?= htmlspecialchars($article['date_publication']); ?>">
        <small id="DateError" class="text-danger" style="display:none;">Valid publication date is required.</small>
    </div>
    <!-- Category -->
    <div class="form-group">
        <label for="Categorie">Category:</label>
        <textarea id="Categorie" name="Categorie" class="form-control"><?= htmlspecialchars($article['categorie']); ?></textarea>
        <small id="CategorieError" class="text-danger" style="display:none;">Category is required.</small>
    </div>
    <div class="form-group">
        <label for="Image">Category:</label>
        <input type="file" id="file" name="file" class="form-control">
        <small id="ImageError" class="text-danger" style="display:none;">Image is required.</small>
    </div>
    <!-- Submit Button -->
    <button type="submit">Update Article</button>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function validateForm() {
    let isValid = true;
    // Get field values
    const Titre = document.getElementById("Titre").value.trim();
    const Contenu = document.getElementById("Contenu").value.trim();
    const date_publication = document.getElementById("date_publication").value;
    const Categorie = document.getElementById("Categorie").value.trim();
    // Clear previous errors
    document.getElementById("TitreError").style.display = "none";
    document.getElementById("ContenuError").style.display = "none";
    document.getElementById("DateError").style.display = "none";
    document.getElementById("CategorieError").style.display = "none";
    // Validate Title
    if (Titre === "") {
        document.getElementById("TitreError").style.display = "block";
        isValid = false;
    }
    // Validate Content
    if (Contenu === "") {
        document.getElementById("ContenuError").style.display = "block";
        isValid = false;
    }
    // Validate Date
    if (date_publication === "") {
        document.getElementById("DateError").style.display = "block";
        isValid = false;
    }
    // Validate Category
    if (Categorie === "") {
        document.getElementById("CategorieError").style.display = "block";
        isValid = false;
    }
    return isValid; // Prevent submission if validation fails
}
</script>
</body>
</html>
