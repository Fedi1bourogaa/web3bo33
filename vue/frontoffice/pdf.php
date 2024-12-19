<?php
// Inclure la bibliothèque TCPDF
require_once 'vendor/autoload.php'; // Remplacez par le chemin correct vers l'autoloader


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

// Récupérer les données des offres
$sql = "SELECT reference, destination, prix FROM offre";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Créer un objet TCPDF
$pdf = new TCPDF();
$pdf->SetFont('helvetica', '', 12);

// Ajouter une page
$pdf->AddPage();

// Titre du PDF
$pdf->Cell(0, 10, 'Liste des Offres', 0, 1, 'C');

// Créer le tableau
$pdf->Ln(10);
$pdf->Cell(30, 10, 'Référence', 1, 0, 'C');
$pdf->Cell(80, 10, 'Destination', 1, 0, 'C');
$pdf->Cell(40, 10, 'Prix (€)', 1, 1, 'C');

// Ajouter les offres au tableau
foreach ($offres as $offre) {
    $pdf->Cell(30, 10, $offre['reference'], 1, 0, 'C');
    $pdf->Cell(80, 10, $offre['destination'], 1, 0, 'C');
    $pdf->Cell(40, 10, $offre['prix'] . ' €', 1, 1, 'C');
}

// Générer le fichier PDF
$pdf->Output('offres.pdf', 'I'); // 'I' pour afficher dans le navigateur, 'D' pour forcer le téléchargement
?>
