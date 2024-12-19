<?php
session_start();

// Check if a product ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Connect to the database (adjust your connection details)
    $host = "localhost";
    $dbname = "elhadhra";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch product details from the database
        $sql = "SELECT * FROM produits WHERE produit_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Add the product to the cart (or update quantity if it already exists)
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity']++;
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => $product['produit_id'],
                'nom' => $product['nom'],
                'prix' => $product['prix'],
                'description' => $product['description'],
                'quantity' => 1,
                'image' => $product['image']
            ];
        }

        // Redirect back to the product page or a cart page
        header('Location: indextemplate.php');
        exit;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>