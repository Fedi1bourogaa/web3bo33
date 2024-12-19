<?php
session_start();


// Check for remove action
if (isset($_GET['id']) && isset($_SESSION['cart'][$_GET['id']])) {
    unset($_SESSION['cart'][$_GET['id']]);
    header('Location: AcheterProduit.php');
    exit;
}

