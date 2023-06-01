<?php

session_start();

require_once('./lib.php');

$depart = $_POST['depart'];
$arrivee = $_POST['arrivee'];
$datetime = $_POST['datetime'];

$lat = $_POST['lat'];
$lng = $_POST['lng'];
$lat2 = $_POST['lat2'];
$lng2 = $_POST['lng2'];

echo '<h1>Recherche de trajet entre '. $depart. ' et '. $arrivee .'</h1>';

$dbh = connect();

$sql = "SELECT * FROM trajet WHERE date > ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("s", $datetime);
$stmt->execute();

echo $datetime;


$result = $stmt->get_result();

while ($trajet = $result->fetch_assoc()) {
    echo $trajet['lieu_depart'].'<br>';
    echo $trajet['lieu_arrivee'].'<br>';

    $distance = distance($lat, $lng, $trajet['lat_depart'], $trajet['lng_depart']);
    $distance2 = distance($lat2, $lng2, $trajet['lat_arrivee'], $trajet['lng_arrivee']);

    echo $distance.'<br>';

}


?>