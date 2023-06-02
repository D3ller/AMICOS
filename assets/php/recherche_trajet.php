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

$result = $stmt->get_result();

$trajetInteressant = null;
$distancePlusInteressante = null;

while ($trajet = $result->fetch_assoc()) {

    $apiUrl = 'https://maps.googleapis.com/maps/api/directions/json?origin='.$lat.','.$lng.'&destination='.$lat2.','.$lng2.'&waypoints='.$trajet['lat'].','.$trajet['lng'].'|'.$trajet['lat2'].','.$trajet['lng2'].'&key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo';
    $response = file_get_contents($apiUrl);
    $directions = json_decode($response, true);

    if ($directions['status'] === 'OK') {
        $distance = $directions['routes'][0]['legs'][0]['distance']['text'];

        if ($trajetInteressant === null || $distance < $distancePlusInteressante) {
            $trajetInteressant = $trajet;
            $distancePlusInteressante = $distance;
        }
    } else {
        echo 'Erreur lors de la récupération du trajet.';
    }
}

if ($trajetInteressant !== null) {
    echo '<h2>Trajet le plus intéressant :</h2>';
    echo 'Lieu de départ : '.$trajetInteressant['lieu_depart'].'<br>';
    echo 'Lieu d\'arrivée : '.$trajetInteressant['lieu_arrivee'].'<br>';
} else {
    echo 'Aucun trajet trouvé.';
}

?>