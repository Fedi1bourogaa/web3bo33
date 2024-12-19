<?php
// Include the articles controller
include 'C:/xampp/htdocs/projet/controller/articleController.php';
// Instantiate the controller
$Pc = new articlesController();
$article = $Pc->getArticleById($_GET['id']);
$Pc->Rating($_GET['id'],$article['rate']+$_GET['nbrStars'],$article['count_rates']+1);
header("Location: front.php");
?>