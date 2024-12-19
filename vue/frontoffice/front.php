<?php
include 'C:\xampp\htdocs\web3bo33\controller\articleController.php';
include 'C:\xampp\htdocs\web3bo33\controller\commentaireController.php';

$Pc = new articlesController();
$Cc = new commentaireController();

// Fetch all articles
$articles = $Pc->getArticles();
// Initialisation de $cartItemCount
$cartItemCount = 0; // Par défaut, aucun article dans le panier

// Vérifiez si le panier existe dans la session et calculez le nombre d'articles
if (isset($_SESSION['cart'])) {
    $cartItemCount = count($_SESSION['cart']);
}

// Initialisation de $user
$user = null; // Par défaut, aucun utilisateur connecté

// Vérifiez si un utilisateur est connecté (par exemple via $_SESSION)
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_comment'])) {
    $name = $_POST['name'];
    $content = $_POST['comment'];
    $articleId = $_POST['article_id'];
    $Cc->addComment($name, $content, $articleId);
}

// Handle comment deletion
if (isset($_GET['delete_comment'])) {
    $Cc->deleteComment($_GET['delete_comment']);
    header("Location: front.php");
    exit;
}

// Handle comment update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_comment'])) {
    $commentId = $_POST['comment_id'];
    $content = $_POST['comment'];
    $Cc->updateComment($commentId, $content);
    header("Location: front.php");
    exit;
}
$idA = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- AOS Animations CSS (Assurez-vous de l'avoir inclus dans votre projet) -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #262626;
            background-color: #9eafbf;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* Container styles */
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 1.5rem;
        }

        .map-container {
            width: 600px;
            /* Largeur de la carte */
            height: 300px;
            /* Hauteur de la carte */
            margin-left: auto;
            /* Centre horizontalement */
            margin-right: auto;
            /* Centre horizontalement */
            display: block;
            /* Pour s'assurer que l'élément est centré comme un bloc */
        }

        .section-header {
            text-align: center;
            margin-bottom: 2rem;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

        }

        .section-header h1 {
            font-size: 2.5rem;
            color: #333;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;

            text-align: left;

        }

        .section-header p {
            font-size: 1.1rem;
            color: #666;
            font-style: italic;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .blog-section {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

        }

        .blog-post,
        .testimonial-form,
        .comment-box {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1 1 calc(50% - 1rem);
        }

        .blog-post img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .blog-post h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 0.5rem;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

        }
        .blog-post h1 {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

        }
        .blog-post p {
            color: #555;
            margin-bottom: 1rem;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

        }

        .blog-post a,
        .read-more a {
            display: inline-flex;
            align-items:right;
            text-decoration: none;
            color:rgb(11, 83, 160);
            font-weight: 500;
            font-size: 1rem;
        }


        /* Testimonial and Comment Box Styling */
        .testimonial-form h2,
        .comment-box h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .testimonial-form input,
        .testimonial-form textarea,
        .comment-box textarea {
            width: 100%;
            padding: 0.8rem;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 1rem;
        }

        .testimonial-form button,
        .comment-box button {
            padding: 0.6rem 1.2rem;
            background-color: #b80e0e;
            color: #fcfcfc;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>


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

<body>
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
          <li><a href="front.php">About Tunisia</a></li>
          <li><a href="#menu">Reservation</a></li>
          <li><a href="#events">Shop</a></li>
          <li><a href="listeventss.php">Events</a></li>
          <li><a href="spon.php">Sponsors</a></li>
          <li><a href="offre.php">Offre</a></li>
          <li><a href="#contact">Contact</a></li>
          <li><a href="AcheterProduit.php">
            
          Panier
    <span class="cart-count"><?php echo $cartItemCount; ?></span>
</a></li>
          <?php if ($user): ?>
          <li>
          <a href="#profile" style="color: red; display: flex; align-items: center;">
          <span style="width: 10px; height: 10px; background-color: green; border-radius: 50%; margin-right: 5px;"></span>
          <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
          </a>
          </li>
             <!-- Lien conditionnel vers la page de mise à jour du profil -->
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
    <hr>
    <section class="about section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header">
                <h1 style="color: red;"><strong>" CULTURE AND HERITAGE OF TUNISIA "</strong></h1>
                <p>"Explore the essence of Tunisia: its history, traditions, and unique flavors."</p>
                <p>Tunisia is a small country in North Africa, bordered by the Mediterranean Sea, Algeria, and Libya. It
                    has a rich history, once home to the ancient Phoenician city-state of Carthage and influenced by
                    Roman, Arab, Ottoman, and French cultures. Tunisia gained independence in 1956 and has since become
                    a republic.

                    The country boasts diverse landscapes, from Mediterranean beaches to the Sahara Desert, and a mild
                    climate in the north. Tunisia is known for its historical sites, such as Carthage and Dougga, and
                    its cuisine, featuring dishes like couscous and brik. The capital is Tunis, and the country plays an
                    important role in the Arab world and North Africa.</p>
            </div>

            <hr>
            <div class="blog-section">
                <!-- Blog Post 1 -->
                <div class="blog-post" data-aos="fade-up" data-aos-delay="100" id="medina">
                    <h2 style="color: red;"> <strong>MEDINA OF TUNIS</strong> </h2>

                    <div class="images-container">
                        <table>
                            <tr>
                                    <p>Art and Craftsmanship Tunisian craftsmanship is a true reflection of the
                                        country’s rich cultural and historical heritage. Berber rugs, known for their
                                        geometric patterns and meticulous weaving, are portable works of art that tell
                                        ancient stories.</br> Traditional pottery, often hand-decorated with floral or
                                        geometric designs, is found in both Tunisian homes and international
                                        markets.</br> The mosaics, particularly those from ancient Carthage and other
                                        historical sites, showcase the technical and aesthetic excellence of Tunisian
                                        art.</br> These works, along with other crafts such as embroidery, leatherwork,
                                        and metalworking, continue to thrive in the souks and workshops, preserving
                                        ancient know-how while adapting to modern trends.</p>
                                </td></tr>
                                <tr>
    <td>
        <img src="assets/img/medina.jpg" alt="La Médina de Tunis - Image 1"
             style="width:500px;height:300px;"><br>
    </td>
    <td>
        <img src="assets/img/medina2.jpg" alt="La Médina de Tunis - Image 2"
             style="width:500px;height:300px;"><br>
    </td>
</tr>
<tr>
    <td colspan="2">
        <p>
            The Medina of Tunis is a UNESCO World Heritage site and a vibrant heart of the capital, offering visitors 
            a fascinating journey through Tunisia's rich history. Founded in the 7th century, it is a maze of narrow, 
            winding streets, traditional houses with colorful doors, and ancient monuments that reflect various periods 
            of cultural influence.<br>
            Within its walls, you’ll find historical sites like the Zitouna Mosque, the heart of Islamic learning in Tunisia, 
            and bustling souks where artisans sell everything from perfumes to jewelry.<br>
            The Medina is a place where the past meets the present, with its mix of traditional craftsmanship, local markets, 
            and modern life, making it a living testimony to the country’s cultural heritage and hospitality.
        </p>
    </td>
</tr>


                        </table>

                    </div>
                    <div class="map-container" id="maps">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12779.334366053143!2d10.158557905106969!3d36.79854005595749!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fd3475f78af271%3A0x8f9049e7ed9a6b78!2sM%C3%A9dina%20de%20Tunis%2C%20Tunis!5e0!3m2!1sfr!2stn!4v1731495726330!5m2!1sfr!2stn"
                            width="600" height="450" style="border:1;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <hr>
                <div class="blog-section">
                    <!-- Blog Post 2 -->
                    <div class="blog-post" data-aos="fade-up" data-aos-delay="100" id="sidibousaid">
    <h2 style="color: red;"> <strong>SIDI BOU SAID</strong> </h2>

    <div class="images-container">
    <!-- Utiliser un chemin relatif pour les images -->
    <img src="assets/img/sidi-bousaid7-1024x768.webp" alt="Sidi Bou Said - Image 1" style="width:500px;height:300px;">
    <img src="assets/img/hero-img.jpg" alt="Sidi Bou Said - Image 2" style="width:500px;height:300px;">
</div>

<p>Sidi Bou Saïd is a picturesque coastal town located near Tunis, famous for its stunning white-and-blue architecture and its breathtaking views of the Mediterranean Sea. The town is named after the revered Sufi saint, Sidi Bou Saïd, who is said to have brought spiritual enlightenment to the area in the 13th century. The charming streets are lined with traditional Tunisian houses, where the doors and windows are painted in a striking shade of blue, creating a unique and harmonious aesthetic. Sidi Bou Saïd has long been a haven for artists, writers, and travelers seeking inspiration from its tranquil atmosphere and natural beauty. The town’s narrow, winding streets lead to the picturesque marina, while cafés and galleries offer visitors the chance to relax and soak in the vibrant cultural scene. With its mix of history, art, and stunning views, Sidi Bou Saïd remains a must-see destination for those wanting to experience the soul of Tunisia.</p>


                        <div class="map-container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12767.141014919089!2d10.332813155166587!3d36.87155870562575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12e2b4995c30ee4d%3A0x674ff5794dd29!2sSidi%20Bou%20Sa%C3%AFd%2C%20Site%20arch%C3%A9ologique%20de%20Carthage!5e0!3m2!1sfr!2stn!4v1731496706229!5m2!1sfr!2stn"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>"
                        </div>
                        <hr>
                        <div class="blog-section">
                            <!-- Blog Post 3 -->
                            <div class="blog-post" data-aos="fade-up" data-aos-delay="100" id="eljem">
                                <h2 style="color: red;"> <strong>EL JEM</strong> </h2>

                                <div class="images-container">
                                    <table>
                                        <tr>
                                            <p>El Jem is a small town in eastern Tunisia, renowned for its majestic
                                                Roman amphitheater, the largest and best-preserved in North Africa.
                                                Built in the 3rd century AD, the amphitheater of El Jem was capable
                                                of seating up to 35,000 spectators, making it one of the largest in
                                                the Roman Empire. This architectural marvel was designed for
                                                gladiator fights and other grand spectacles, reflecting the
                                                importance of the region within the empire. Constructed entirely of
                                                stone blocks and lacking any foundational support, the amphitheater
                                                is an impressive testament to Roman engineering and architectural
                                                skill. Today, El Jem stands as a UNESCO World Heritage site, drawing
                                                visitors from around the globe who come to marvel at its grandeur
                                                and historical significance. The town itself, with its blend of
                                                ancient Roman and Tunisian culture, offers a unique glimpse into
                                                Tunisia’s rich past.</p>
                                        </tr>
                                        <tr>
                                            <td><img src="assets/img/ELJEM.jpg" alt="La Médina de Tunis - Image 1"
                                                    style="width:500px;height:300px;">
                                            <td><img src="assets/img/ELJEM2.JPG" alt="La Médina de Tunis - Image 1"
                                                    style="width:500px;height:400px;"></br>
                                            </td>
                                        </tr>

                                    </table>

                                </div>
                                <div class="map-container">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26051.472862568407!2d10.685748780839395!3d35.295193503677964!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1301fc8250fbd357%3A0x2ac18b0a4bde5c20!2sEl%20Jem!5e0!3m2!1sfr!2stn!4v1731518735082!5m2!1sfr!2stn"
                                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                                <hr>
                                <div class="blog-section">
                                    <!-- Blog Post 4 -->
                                    <div class="blog-post" data-aos="fade-up" data-aos-delay="100" id="tozeur">
    <h2 style="color: red;"> <strong>TOZEUR</strong> </h2>

    <div class="images-container">
        <!-- Ajout des images avec des chemins relatifs -->
        <img src="assets/img/tozeur1.jpg" alt="Tozeur - Image 1" style="width:500px;height:300px;">
        <img src="assets/img/tozeur2.jpg" alt="Tozeur - Image 2" style="width:500px;height:300px;">
    </div>

    <p>Tozeur is an oasis city in southwestern Tunisia, celebrated for its stunning desert landscapes, lush date palm groves, and distinct Saharan architecture. Known as the gateway to the Sahara, Tozeur is surrounded by a vast palm oasis that produces some of the finest dates in the world, including the famous deglet nour, or "date of light." The city’s architecture features unique brick patterns and earthy tones, giving it a timeless and authentic character that sets it apart from other Tunisian towns.

    Tozeur is also home to historical sites, such as the Medina, with its labyrinthine alleys and traditional souks, and the 14th-century Sidi Bou Aïssa Mosque. Nearby attractions include the shimmering Chott el-Jerid salt flats and several picturesque mountain oases, like Chebika and Tamerza, which offer breathtaking views of waterfalls, rocky cliffs, and lush valleys. The area has also served as a backdrop for many films, including parts of the Star Wars series, adding to its allure for visitors and film enthusiasts alike.</p>
</div>

                                        <div class="map-container">
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d52973.97552166036!2d8.041899341785292!3d33.91865595189307!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1257c028313d134d%3A0xc48c27f26a58203!2sTozeur!5e0!3m2!1sfr!2stn!4v1731519142803!5m2!1sfr!2stn"
                                                width="600" height="450" style="border:0;" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                            </iframe>
                                        </div>
                                        <hr>
                                        <div class="blog-section">
                                            <!-- Blog Post 5 -->
                                            <div class="blog-post" data-aos="fade-up" data-aos-delay="100"
                                                id="aindrahem">
                                                <h2 style="color: red;"> <strong>AIN DRAHEM</strong> </h2>

                                                <div class="blog-post" data-aos="fade-up" data-aos-delay="100" id="aindraham">

    <tr><div class="images-container">
        <!-- Utilisation de chemins relatifs pour les images -->
        <td><img src="assets/img/AIN1.jpg" alt="Aïn Draham - Image 1" style="width:450px;height:250px;"></td>
        <td><img src="assets/img/aiin-draham-960x642.jpg" alt="Aïn Draham - Image 2" style="width:450px;height:250px;"></td></tr>
    </div>

    <p>Aïn Draham is a picturesque town nestled in the lush, mountainous northwest region of Tunisia, known for its green hills, dense forests, and cool climate. Situated in the Kroumirie Mountains near the Algerian border, Aïn Draham is a popular destination for those seeking natural beauty, tranquility, and outdoor activities. The town is particularly famous for its cork oak forests, which cover the surrounding hills, making it one of Tunisia's greenest areas.

    In winter, Aïn Draham often experiences cooler temperatures and even snow, making it a unique spot in Tunisia where visitors can enjoy a different climate. The town’s charming architecture features red-tiled roofs, adding to its European-like appeal. Aïn Draham is also a starting point for hiking, trekking, and exploring nearby attractions, including scenic villages, springs, and ancient ruins. Known as a haven for nature lovers, this town provides a peaceful escape into Tunisia's diverse landscape.</p>
</div>


                                                    </table>

                                                </div>
                                                <div class="map-container">
                                                    <iframe
                                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12783.346430294383!2d8.675658705087347!3d36.774487006067375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fb3ae643c73ce5%3A0x54c417647b890cb1!2sAin%20Draham!5e0!3m2!1sfr!2stn!4v1731519548064!5m2!1sfr!2stn"
                                                        width="600" height="450" style="border:0;" allowfullscreen=""
                                                        loading="lazy"
                                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                </div>
                                                <hr>
                                                <div class="blog-section">
                                                    <!-- Blog Post 6 -->
                                                    <div class="blog-post" data-aos="fade-up" data-aos-delay="100"
                                                        id="kelibia">
                                                        <h2 style="color: red;"> <strong>KÉLIBIA</strong> </h2>

                                                        <div class="blog-post" data-aos="fade-up" data-aos-delay="100" id="kelibia">

    <div class="images-container">
        <!-- Utilisation de chemins relatifs pour les images -->
        <img src="assets/img/kelibia1.jpg" alt="Kélibia - Image 1" style="width:470px;height:270px;">
        <img src="assets/img/Kelibia2.jpg" alt="Kélibia - Image 2" style="width:470px;height:270px;">
    </div>

    <p>Kélibia is a coastal town located on the northeastern tip of Tunisia, famous for its stunning beaches, historical sites, and vibrant fishing port. Known for its pristine turquoise waters and sandy shores, Kélibia attracts beach lovers and visitors seeking relaxation along the Mediterranean coast. One of its most iconic landmarks is the Kélibia Fort (or Kélibia Castle), a fortress dating back to the Punic and Roman periods that stands on a hill overlooking the sea. This well-preserved fort offers panoramic views of the coastline and surrounding countryside, making it a must-see for tourists.

    Kélibia is also known for its wine production, particularly Muscat wine, which has garnered international recognition for its quality and unique flavor. Each summer, the town hosts a wine festival celebrating its winemaking heritage. With its rich blend of history, beautiful beaches, and cultural traditions, Kélibia is a gem on Tunisia’s Cap Bon Peninsula, offering a delightful experience for history enthusiasts, beachgoers, and culinary lovers alike.</p>
</div>

                                                        <hr>

                                                        <div class="map-container">
                                                            <iframe
                                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d51089.57220780786!2d11.05512032383374!3d36.840122642032824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x131d338ce17b9879%3A0x351ce2ee2df67ff3!2zS8OpbGliaWE!5e0!3m2!1sfr!2stn!4v1731520245297!5m2!1sfr!2stn"
                                                                width="600" height="450" style="border:0;"
                                                                allowfullscreen="" loading="lazy"
                                                                referrerpolicy="no-referrer-when-downgrade"></iframe>

                                                        </div>
                                                        <!-- Blog Post 7-->
                                                        <div class="blog-post" data-aos="fade-up" data-aos-delay="200" id="TraditionalTunisianMusic">
    <h2 style="color: red;"> <strong>Traditional TUNISIAN MUSIC</strong> </h2>

    <div class="images-container">
        <!-- Utilisation des chemins relatifs pour les images -->
        <img src="assets/img/music1.jpg" alt="Traditional Tunisian Music - Image 1" style="width:470px;height:270px;">
        <img src="assets/img/music2.jpg" alt="Traditional Tunisian Music - Image 2" style="width:470px;height:270px;">
    </div>

    <p>Traditional Tunisian music is deeply rooted in the country's rich history, drawing influences from Berber, Arab, and Andalusian cultures. One of the most iconic styles is the Malouf, a form of classical music brought to Tunisia by Andalusian refugees in the 15th century. Characterized by intricate rhythms, poetic lyrics, and unique modes, Malouf is often performed with traditional instruments like the oud (lute), qanun (zither), nay (flute), and darbouka (drum).

    In addition to Malouf, various regional folk styles express Tunisia's diverse cultural landscape. The music of the south, for example, often features rhythmic chants and the use of the mezoued (a type of bagpipe) and bendir (frame drum), reflecting Bedouin and desert influences. The music of Tunisia plays a central role in cultural celebrations, festivals, and daily life, preserving stories, values, and local identities while evolving with modern sounds and contemporary influences.</p>
</div>

                                                            <hr>
                                                            <!-- Blog Post 7-->
                                                           
    </section>

    <!-- AOS Animations Script -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init();
    </script>
    <script src="FrontAboutTunisia.js"></script>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">



    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #262626;
            background-color: #9eafbf;
        }

        .blog-section {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .blog-post {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1 1 calc(50% - 1rem);
            margin-bottom: 1rem;
        }

        .blog-post h2 {
            font-size: 1.8rem;
            color: #333;
        }

        .blog-post p {
            color: #555;
        }

        .comment-box {
            background: #f9f9f9;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 15px;
        }

        .comment-box ul {
            list-style: none;
            padding: 0;
        }

        .comment-box li {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .comment-box li:last-child {
            border-bottom: none;
        }

        .btn {
            margin-top: 5px;
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: #262626;
            background-color: #9eafbf;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* Container styles */
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 1.5rem;
        }

        .map-container {
            width: 600px;
            /* Largeur de la carte */
            height: 300px;
            /* Hauteur de la carte */
            margin-left: auto;
            /* Centre horizontalement */
            margin-right: auto;
            /* Centre horizontalement */
            display: block;
            /* Pour s'assurer que l'élément est centré comme un bloc */
        }

        .section-header {
            text-align: center;
            margin-bottom: 2rem;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

        }

        .section-header h1 {
            font-size: 2.5rem;
            color: #333;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;


        }

        .section-header p {
            font-size: 1.1rem;
            color: #666;
            font-style: italic;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .blog-section {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

        }

        .blog-post,
        .testimonial-form,
        .comment-box {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1 1 calc(50% - 1rem);
        }

        .blog-post img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .blog-post h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 0.5rem;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

        }

        .blog-post p {
            color: #555;
            margin-bottom: 1rem;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

        }

        .blog-post a,
        .read-more a {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
            font-size: 1rem;
        }


        /* Testimonial and Comment Box Styling */
        .testimonial-form h2,
        .comment-box h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .testimonial-form input,
        .testimonial-form textarea,
        .comment-box textarea {
            width: 100%;
            padding: 0.8rem;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 1rem;
        }

        .testimonial-form button,
        .comment-box button {
            padding: 0.6rem 1.2rem;
            background-color: #b80e0e;
            color: #fcfcfc;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

/* Modal styles */
.modal {
  display: none; /* Hidden by default */
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fff;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 90%;
  max-width: 400px;
  border-radius: 10px;
  text-align: center;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover {
  color: #000;
}

/* Star rating styles */
.star {
  font-size: 50px;
  cursor: pointer;
  color: lightgray; /* Default color for unselected stars */
}
.starr {
  font-size: 50px;
  cursor: pointer;
  color: lightgray; /* Default color for unselected stars */
}

.one {
  color: rgb(255, 0, 0);
}

.two {
  color: rgb(255, 106, 0);
}

.three {
  color: rgb(251, 255, 120);
}

.four {
  color: rgb(255, 255, 0);
}

.five {
  color: rgb(24, 159, 14);
}


    </style>
    <link href="assets/css/main.css" rel="stylesheet">
</head>

<body>
    

    <section class="about section">
        <div class="container">
            <div class="blog-section">
                <?php foreach ($articles as $article): 
               
                    if($article['count_rates'] == 0){
                    $rr = 0;
                    }
                    else{
                        $rr = floor($article['rate'] / $article['count_rates']);
                    }
                    
                    ?>

                    <div class="blog-post" data-aos="fade-up">
                    <div class="blog-post" data-aos="fade-up" style="display: flex; align-items: flex-start; gap: 20px;">
    <!-- Image Section -->
    <div class="image-container">
        <img src="../uploads/<?= htmlspecialchars($article['image']); ?>" alt="Article Image" style="width: 200px; height: auto; object-fit: cover; border-radius: 10px;">
    </div>
    
    <!-- Content Section -->
    <div class="content-container">
        <h2><?= htmlspecialchars($article['titre']); ?></h2>
        <p><?= htmlspecialchars($article['contenu']); ?></p>
        <p><strong>Published:</strong> <?= htmlspecialchars($article['date_publication']); ?></p>
        <div class="rating">
            <?php if($rr == 1) { ?>
                <span class="starr one"><?= str_repeat('★', $rr); ?></span>
            <?php } else if($rr == 2) { ?>
                <span class="starr two"><?= str_repeat('★', $rr); ?></span>
            <?php } else if($rr == 3) { ?>
                <span class="starr three"><?= str_repeat('★', $rr); ?></span>
            <?php } else if($rr == 4) { ?>
                <span class="starr four"><?= str_repeat('★', $rr); ?></span>
            <?php } else if($rr == 5) { ?>
                <span class="starr five"><?= str_repeat('★', $rr); ?></span>
            <?php } ?>
            <span class="starr"><?= str_repeat('★', 5 - $rr); ?></span>
        </div>
        <button class="openDialogButton btn btn-primary btn-sm" data-article-id="<?php echo $article['id']; ?>">Rate Now</button>
    </div>
</div>

                        <!-- Comments Section -->
                        <div class="comment-box">
                            <h3>Comments</h3>
                            <ul>
                                <?php
                                $comments = $Cc->getCommentsByArticle($article['id']);
                                foreach ($comments as $comment): ?>
                                    <li>
                                        <strong><?= htmlspecialchars($comment['nom']); ?></strong>:
                                        <?= htmlspecialchars($comment['contenu_comm']); ?>
                                        <form method="POST" action="" class="d-inline">
                                            <input type="hidden" name="comment_id" value="<?= $comment['id']; ?>">
                                            <input type="text" name="comment" value="<?= htmlspecialchars($comment['contenu_comm']); ?>" class="form-control" required>
                                            <button type="submit" name="update_comment" class="btn btn-primary btn-sm">Update</button>
                                        </form>
                                        <a href="?delete_comment=<?= $comment['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this comment?');">Delete</a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <!-- Add Comment Form -->
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="name">Your Name:</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Your Comment:</label>
                                    <textarea name="comment" class="form-control" rows="3" required></textarea>
                                </div>
                                <input type="hidden" name="article_id" value="<?= $article['id']; ?>">
                                <button type="submit" name="add_comment" class="btn btn-primary mt-2">Add Comment</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Modal -->
<div id="ratingDialog" class="modal">
    <div class="modal-content">
        <span id="closeDialogButton" class="close">&times;</span>
        <h1>Rate This Item</h1>
        <div class="rating-container">
            <span onclick="updateRating(1)" class="star">★</span>
            <span onclick="updateRating(2)" class="star">★</span>
            <span onclick="updateRating(3)" class="star">★</span>
            <span onclick="updateRating(4)" class="star">★</span>
            <span onclick="updateRating(5)" class="star">★</span>
        </div>
        <h3 id="output">Rating is: 0/5</h3>
        <a id="validateButton" href="#" class="btn btn-danger btn-sm">Valider</a>
    </div>
</div>


                <?php endforeach; ?>
            </div>
        </div>
    </section>
     <!-- Contact Section -->
<section id="contact" class="contact section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>Contact</h2>
  <p><span>Need Help?</span> <span class="description-title">Contact Us</span></p>
</div><!-- End Section Title -->

<div class="container" data-aos="fade-up" data-aos-delay="100">

  <!-- Google Maps Embed -->
  <div class="mb-5">
    <iframe style="width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11550.544689730721!2d10.18153229641437!3d36.89173953374031!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12e2cb75abbb1733%3A0x557a99cdf6c13b7b!2sESPRIT%20Ecole%20Sup%C3%A9rieure%20Priv%C3%A9e%20d&#39;Ing%C3%A9nierie%20et%20de%20Technologies!5e1!3m2!1sfr!2stn!4v1731491614162!5m2!1sfr!2stn" frameborder="0" allowfullscreen=""></iframe>
  </div><!-- End Google Maps -->

  <!-- Contact Info -->
  <div class="row gy-4">

    <div class="col-md-6">
      <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
        <i class="icon bi bi-geo-alt flex-shrink-0"></i>
        <div>
          <h3>Address</h3>
          <p>1, Pôle Technologique, 2 Rue André Ampère، Ariana 2083,Tunisie</p>
        </div>
      </div>
    </div><!-- End Info Item -->

    <div class="col-md-6">
      <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="300">
        <i class="icon bi bi-telephone flex-shrink-0"></i>
        <div>
          <h3>Call Us</h3>
          <p>+21655724828</p>
        </div>
      </div>
    </div><!-- End Info Item -->

    <div class="col-md-6">
      <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="400">
        <i class="icon bi bi-envelope flex-shrink-0"></i>
        <div>
          <h3>Email Us</h3>
          <p>ELHADHRA@gmail.com</p>
        </div>
      </div>
    </div><!-- End Info Item -->

    <div class="col-md-6">
      <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="500">
        <i class="icon bi bi-clock flex-shrink-0"></i>
        <div>
          <h3>Opening Hours<br></h3>
          <p><strong>Mon-Sat:</strong> 9AM - 23PM; <strong>Sunday:</strong> Closed</p>
        </div>
      </div>
    </div><!-- End Info Item -->

  </div><!-- End Contact Info -->        
        <!-- "Recrutement des guides" button added -->
       <center> <a href="recrutement.html" class="btn btn-primary mt-3">Recrutement des guides</a> 
       <a href="partenaires.html" class="btn btn-secondary mt-3">A Propos de Nos Partenaires</a>
        <a href="dashboard_guide.php" class="btn btn-secondary mt-3">Candidature</a></center>
      </div>
      
    </div>
  </form><!-- End Contact Form -->

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer dark-background">

    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-geo-alt icon"></i>
          <div class="address">
            <h4>Address</h4>
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p></p>
          </div>

        </div>

        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-telephone icon"></i>
          <div>
            <h4>Contact</h4>
            <p>
              <strong>Phone:</strong> <span>+1 5589 55488 55</span><br>
              <strong>Email:</strong> <span>info@example.com</span><br>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-clock icon"></i>
          <div>
            <h4>Opening Hours</h4>
            <p>
              <strong>Mon-Sat:</strong> <span>11AM - 23PM</span><br>
              <strong>Sunday</strong>: <span>Closed</span>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <h4>Follow Us</h4>
          <div class="social-links d-flex">
            <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Yummy</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

   

    <script src="assets/vendor/aos/aos.js"></script>
    <script>
        AOS.init();
    </script>
  <script>
    // Access modal elements
    const ratingDialog = document.getElementById("ratingDialog");
    const closeDialogButton = document.getElementById("closeDialogButton");
    let buttonId;

    // Attach click event listeners to all buttons
    document.querySelectorAll(".openDialogButton").forEach((button) => {
        button.addEventListener("click", function () {
            ratingDialog.style.display = "block";
            buttonId = this.getAttribute("data-article-id"); // Fetch the article ID
        });
    });

    // Close the dialog
    closeDialogButton.onclick = () => {
        ratingDialog.style.display = "none";
    };

    // Close dialog when clicking outside of it
    window.onclick = (event) => {
        if (event.target === ratingDialog) {
            ratingDialog.style.display = "none";
        }
    };

    // Star rating functionality
    let stars = document.getElementsByClassName("star");
    let output = document.getElementById("output");

    function updateRating(rating) {
        let currentRating = 0;
        clearStyles();
        for (let i = 0; i < rating; i++) {
            let className = ["one", "two", "three", "four", "five"][rating - 1];
            stars[i].className = `star ${className}`;
        }
        output.innerText = `Rating is: ${rating}/5`;

        currentRating = rating;
        document.getElementById("output").textContent = `Rating is: ${currentRating}/5`;

        // Update the link dynamically with the rating
        const validateButton = document.getElementById("validateButton");
        validateButton.href = `rating.php?id=${buttonId}&nbrStars=${currentRating}`;
    }

    function clearStyles() {
        for (let i = 0; i < stars.length; i++) {
            stars[i].className = "star";
        }
    }
    
</script>
<script>
window.embeddedChatbotConfig = {
chatbotId: "BscfpbBORAJtWs2ko5vVH",
domain: "www.chatbase.co"
}
</script>
<script
src="https://www.chatbase.co/embed.min.js"
chatbotId="BscfpbBORAJtWs2ko5vVH"
domain="www.chatbase.co"
defer>
</script>

</body>
<hr>
                                                                

                                                                <nav>
                                                                    <ul>
                                                                        <li><a href="#medina">Medina</a></li>
                                                                        <li><a href="#kelibia">Kélibia</a></li>
                                                                        <li><a href="#sidibousaid">Sidi Bou Saïd</a>
                                                                        </li>
                                                                        <li><a href="#eljem">El Jem</a></li>
                                                                        <li><a href="#aindrahem">Ain Drahem</a></li>
                                                                        <li><a href="#tozeur">Tozeur</a></li>
                                                                        <li><a href="#TraditionalTunisianMusic">Traditional
                                                                                Tunisian Music</a></li>
                                                                    </ul>
                                                                </nav>
</html>