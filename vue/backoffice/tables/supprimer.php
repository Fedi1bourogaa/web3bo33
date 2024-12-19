<?php
require_once '../../../Controller/CategoriesController.php';
require_once __DIR__ . '/../../../Controller/CommandeController.php';
require_once __DIR__ . '/../../../Controller/ProduitsController.php';


if (isset($_GET['idP']) && $_GET['idP'] != '') {
    $Pc = new ProduitsController();
    $Pc->deleteProduit($_GET['idP']);
    header('Location: tables.php');
    exit();
}
if (isset($_GET['idC']) && $_GET['idC'] != '') {
    $Cc = new CategoriesController();
    $Cc->deleteCategorie($_GET['idC']);
    header('Location: tables.php');
    exit(); 
}
if (isset($_GET['ID_commande']) && $_GET['ID_commande'] != '') {
    $Cc = new CommandeController();
    $Cc->deleteCommande($_GET['ID_commande']);
    header('Location: tables.php');
    exit(); 
}

?>