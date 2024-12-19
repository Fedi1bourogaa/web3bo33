<?php
session_start();

// Initialisation de $user
$user = null;

// Vérifiez si un utilisateur est connecté
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ELHADHRA</title>
  <meta name="description" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <style>
    /* Ensure the footer stays at the bottom */
    body, html {
      height: 100%;
      margin: 0;
    }

    .main {
      min-height: calc(100vh - 150px); /* Adjust the height based on footer size */
    }

    footer {
      position: relative;
      bottom: 0;
      width: 100%;
      background-color: #2c3e50;
      color: #fff;
      padding: 20px 0;
      text-align: center;
    }

    /* Modal Styling */
    #reservationModal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    #reservationModal .modal-content {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
    }

    .btn-export-pdf {
      margin-top: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
    }

    .btn-export-pdf:hover {
      background-color: #45a049;
    }
    /* Book Button Style */
button[type="submit"] {
  background-color: #3498db; /* Blue color for the button */
  color: #fff; /* White text color */
  border: none; /* Remove the border */
  padding: 12px 24px; /* Add padding around the text */
  font-size: 16px; /* Font size */
  font-weight: bold; /* Make text bold */
  text-transform: uppercase; /* Uppercase text */
  cursor: pointer; /* Change cursor to pointer */
  border-radius: 5px; /* Rounded corners */
  transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transitions */
}

/* Hover and Focus Effects */
button[type="submit"]:hover, button[type="submit"]:focus {
  background-color: #2980b9; /* Darker blue on hover/focus */
  transform: scale(1.05); /* Slightly enlarge the button */
}

/* Disabled State */
button[type="submit"]:disabled {
  background-color: #bdc3c7; /* Grey color when disabled */
  cursor: not-allowed; /* Change cursor to not-allowed */
}

  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="http://localhost/web3bo33/vue/frontoffice/indextemplate.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename" style="color: rgb(7, 6, 6);">ELHADHRA</h1>
        <span>.</span>
      </a>

      <ul>
        <li><a href="http://localhost/web3bo33/vue/frontoffice/indextemplate.php">Home<br></a></li>
        <li><a href="reservation.php" class="active">Reservation</a></li>

        <?php if ($user): ?>
            <li>
                <a href="#profile" style="color: red; display: flex; align-items: center;">
                    <span style="width: 10px; height: 10px; background-color: green; border-radius: 50%; margin-right: 5px;"></span>
                    <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?>
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>

    </div>
  </header>

  <main class="main">
    <div>
      <section id="hero" class="hero section light-background">
        <div class="container">
          <div class="row gy-4 justify-content-center justify-content-lg-between">
            <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center">
              <h1 data-aos="fade-up">"عسلامة"<br>Enjoy your journey in Tunisia</h1>
              <p data-aos="fade-up" data-aos-delay="100">
                Welcome to El Hadhra, your gateway to the rich and diverse culture of Tunisia. Our website is dedicated to exploring the vibrant history, art, music, traditions, and hidden gems of this beautiful land.</p>
              <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                <a href="#book-a-table" class="btn-get-started">تونسنا</a>
                <a href="C:\Users\ghodh\Downloads\elhadhra\elhadhra\assets\img" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
              </div>
            </div>
            <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
              <img src="assets/img/hero-img.jpg" class="img-fluid animated" alt="">
            </div>
          </div>
        </div>
      </section>
    </div>
    <br>
    <br>
    <div class="container">
      <div class="row g-0" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-12 d-flex align-items-center reservation-form-bg" data-aos="fade-up" data-aos-delay="200">
          <form id="reservationForm" action="book-a-table.php" method="post" role="form" class="php-email-form">
            <div class="row gy-4">
              <div class="col-lg-4 col-md-6">
                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required="">
              </div>
              <div class="col-lg-4 col-md-6">
                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
              </div>
              <div class="col-lg-4 col-md-6">
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone" required="">
              </div>
              <div class="col-lg-4 col-md-6">
                <input type="date" name="check in" class="form-control" id="check-in" placeholder="Date" required="">
              </div>
              <div class="col-lg-4 col-md-6">
                <input type="date" class="form-control" name="check out" id="check-out" placeholder="Time" required="">
              </div>
              <div class="col-lg-4 col-md-6">
                <select name="room_type" class="form-control" id="room-type" required>
                  <option value="SIMPLE">SIMPLE</option>
                  <option value="DOUBLE">DOUBLE</option>
                  <option value="TRIPLE">TRIPLE</option>
                </select>
              </div>
            </div>
            <div class="text-center mt-3">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your booking request was sent. We will call back or send an Email to confirm your reservation. Thank you!</div>
              <button type="submit" id="bookButton" style="
  background-color:rgb(255, 25, 0); 
  color: #fff; 
  border: none; 
  padding: 12px 24px; 
  font-size: 16px; 
  font-weight: bold; 
  text-transform: uppercase; 
  cursor: pointer; 
  border-radius: 5px; 
  transition: background-color 0.3s ease, transform 0.3s ease;
" onmouseover="this.style.backgroundColor='#c0392b'; this.style.transform='scale(1.05)';" onmouseout="this.style.backgroundColor='#e74c3c'; this.style.transform='scale(1)';">
  Book!
</button>
            </div>
          </form>
        </div><!-- End Reservation Form -->
      </div>
    </div>
  </main>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>

  <footer id="footer" class="footer dark-background">
    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-geo-alt icon"></i>
          <div class="address">
            <h4>Address</h4>
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
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
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- jsPDF library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Custom JS for Modal and PDF Export -->
  <script>
    const { jsPDF } = window.jspdf;

    // Handle the button click
    document.getElementById('reservationForm').addEventListener('submit', function (event) {
  // Prevent the default form submission
  event.preventDefault();

  // Show the confirmation modal
  const modal = document.createElement('div');
  modal.id = 'reservationModal';
  modal.classList.add('d-flex');

  // Modal content
  modal.innerHTML = `
    <div class="modal-content">
      <h3>Reservation Made</h3>
      <p>Your reservation has been confirmed!</p>
      <button class="btn-export-pdf" id="exportPDF">Export Details as PDF</button>
      <button onclick="document.getElementById('reservationModal').remove();">Close</button>
    </div>
  `;
  
  document.body.appendChild(modal);

  // Handle PDF export
  document.getElementById('exportPDF').addEventListener('click', function () {
    const doc = new jsPDF();
    doc.text("Reservation Details:", 20, 30);
    doc.text(`Name: ${document.getElementById('name').value}`, 20, 40);
    doc.text(`Email: ${document.getElementById('email').value}`, 20, 50);
    doc.text(`Phone: ${document.getElementById('phone').value}`, 20, 60);
    doc.text(`Check-in: ${document.getElementById('check-in').value}`, 20, 70);
    doc.text(`Check-out: ${document.getElementById('check-out').value}`, 20, 80);
    doc.text(`Room Type: ${document.getElementById('room-type').value}`, 20, 90);
    doc.save('reservation-details.pdf');
  });
});

  </script>

</body>

</html>
