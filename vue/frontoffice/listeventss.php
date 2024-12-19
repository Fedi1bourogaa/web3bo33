<?php
include '../../controller/EventE.php';
include '../../controller/SponsorS.php';



// Instancier le contrôleur et récupérer la liste des événements
$eventE = new EventE();
$list = $eventE->listEvents();
$SponS = new SponsorS();
$listt = $SponS-> listSponsors()

?>
<link rel="stylesheet" href="style.css">
    <script src="https://js.puter.com/v2/"></script> <!-- Include Puter.js for Text-to-Speech -->
</head>
<body>
    <!-- Events Section -->
   
    <section id="events" class="events section">
        <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
                {
                  "loop": true,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": "auto",
                  "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 1,
                      "spaceBetween": 40
                    },
                    "1200": {
                      "slidesPerView": 3,
                      "spaceBetween": 1
                    }
                  }
                }
                </script>
                <div class="container mt-4">
    <div class="row">
        <?php
        // Boucle pour afficher les événements
        foreach ($list as $event) {
        ?>
            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                <div class="card shadow-lg border-0 event-card">
                    <!-- Image de l'événement -->
                    <img src="<?= htmlspecialchars($event['image']); ?>" 
                         class="card-img-top" 
                         alt="Image of <?= htmlspecialchars($event['nom_event']); ?>"
                         style="height: 200px; object-fit: cover; border-radius: 10px 10px 0 0;">
                    
                    <!-- Contenu de la carte -->
                    <div class="card-body d-flex flex-column text-center">
                        <h5 class="card-title font-weight-bold mb-3"><?= htmlspecialchars($event['nom_event']); ?></h5>
                        <p class="card-text">
                            <strong>Date :</strong> <?= htmlspecialchars($event['date_event']); ?><br>
                            <strong>Type :</strong> <?= htmlspecialchars($event['type']); ?>
                        </p>
                        
                        <!-- Bouton Text-to-Speech -->
                        <button class="tts-button btn btn-primary btn-sm mt-auto" 
                                data-description="<?= htmlspecialchars($event['type']); ?>">
                            🔊 Lire le Type
                        </button>

                        <!-- Bouton Like -->
                        <div class="like-container mt-3">
                            <button class="like-button btn btn-outline-danger btn-sm">
                                ❤️ <span class="like-count">0</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<!-- CSS amélioré -->
<style>
/* Styling global */
body {
    background-color: #f8f9fa;
    font-family: 'Arial', sans-serif;
}

.event-card {
    border-radius: 10px;
    overflow: hidden;
    background-color: #ffffff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.card-title {
    font-size: 1.25rem;
    color: #343a40;
}

.card-text {
    font-size: 0.9rem;
    color: #6c757d;
}

.like-button {
    font-size: 0.9rem;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.like-button:hover {
    background-color: #dc3545;
    color: #fff;
}

.tts-button {
    background-color: #007bff;
    color: white;
    transition: background-color 0.3s ease;
}

.tts-button:hover {
    background-color: #0056b3;
}
</style>
<script>
        // Like Button Functionality for Each Event
        document.querySelectorAll('.like-button').forEach((button) => {
            let count = 0; // Initialize count for each button
            const likeCountElement = button.querySelector('.like-count');

            button.addEventListener('click', () => {
                count++;
                likeCountElement.textContent = count; // Update the count for this button
            });
        });

        // Text-to-Speech Functionality
        document.querySelectorAll('.tts-button').forEach(button => {
            button.addEventListener('click', () => {
                const description = button.getAttribute('data-description'); // Fetch the event type
                puter.ai.txt2speech(description)
                    .then(audio => {
                        audio.play();
                    })
                    .catch(error => {
                        console.error('Error with Text-to-Speech:', error);
                    });
            });
        });
    </script>

</div>