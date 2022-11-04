<?php
$cn = mysqli_connect("localhost", "root", "", "vrd");
// On se connecte à là base de données
require_once('connect.php');

$sql = 'SELECT * FROM `bc_articles` ';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute
$query->execute();

// On récupère les valeurs dans un tableau associatif
$articles = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
?>