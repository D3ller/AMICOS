<?php

session_start();

require_once('./lib.php');

$depart = $_POST['depart'];
$arrivee = $_POST['arrivee'];

echo '<h1>Recherche de trajet entre'. $depart. ' '. $arrivee .'</h1>';



?>