<?php
session_start();

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$host = 'localhost';
$dbname = 'elhadhra';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer les données de l'utilisateur connecté
$user = null; // Initialize user variable
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT prenom, nom, role FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data
}

// Récupérer les offres
$sql = "SELECT reference, destination, prix, image FROM offre";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ELHADHRA</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link rel="stylesheet" href="chatboot.css">
<script src="chatboot.js" defer></script>

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Yummy
  * Template URL: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename" style="color: red;">ELHADHRA</h1>
        <span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home<br></a></li>
          <li><a href="#about">About Tunisia</a></li>
          <li><a href="#menu">Reservation</a></li>
          <li><a href="#events">Shop</a></li>
          <li><a href="offre.php">Offre</a></li>
          <li><a href="#contact">Contact</a></li>
          <?php if ($user): ?>
    <li>
        <a href="#profile" style="color: red; display: flex; align-items: center;">
            <span style="width: 10px; height: 10px; background-color: green; border-radius: 50%; margin-right: 5px;"></span>
            <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
        </a>
    </li>
    <?php if ($user['role'] == 'visiteur'): ?>
        <li><a href="visiteur_profile.php" style="color: black;">Modifier profil</a></li>
        <li><a href="evaluationsite.php" style="color: black;">Évaluer le site</a></li>
    <?php elseif ($user['role'] == 'guide'): ?>
        <li><a href="guide_profile.php" style="color: black;">Modifier profil</a></li>
    <?php elseif ($user['role'] == 'partenaire'): ?>
        <li><a href="partenaire_profile.php" style="color: black;">Modifier profil</a></li>
    <?php endif; ?>
    <li><a href="logout.php" style="color: #b71c1c;">Déconnexion</a></li>
<?php else: ?>
    <li><a href="login.php" style="color: #b71c1c;">Se connecter</a></li>
<?php endif; ?>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="index.php#book-a-table">GET STARTED</a>

    </div>
  </header>
    <div class="container">
        <h1>Dashboard des Offres</h1>

        <!-- Ajouter un bouton pour générer le PDF -->
        <div class="actions-global">
            <a href="ajouter_offre.php">Ajouter une nouvelle offre</a>
            <a href="pdf.php" target="_blank">Générer le PDF</a>
        </div>

        <!-- Grille des offres -->
        <div class="grid">
            <?php foreach ($offres as $offre): ?>
                <div class="card">
                    <img src="<?php echo htmlspecialchars($offre['image'] ?? 'placeholder.jpg'); ?>" alt="Image de l'offre">
                    <div class="content">
                        <h3><?php echo htmlspecialchars($offre['destination']); ?></h3>
                        <p>Référence : <?php echo htmlspecialchars($offre['reference']); ?></p>
                        <p>Prix : <?php echo htmlspecialchars($offre['prix']); ?> DT</p>
                        <div class="actions">
                            <a href="modifier_offre.php?reference=<?php echo urlencode($offre['reference']); ?>">Modifier</a>
                            <a href="supprimer_offre.php?reference=<?php echo urlencode($offre['reference']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?');">Supprimer</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
