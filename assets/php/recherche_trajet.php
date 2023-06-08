<?php

session_start();

echo '<link type="text/css" rel="stylesheet" href="/assets/css/header-footer.css">';

require_once('./lib.php');
include_once('./header.php');

$depart = $_POST['depart'];
$arrivee = $_POST['arrivee'];
$datetime = $_POST['date'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$lat2 = $_POST['lat2'];
$lng2 = $_POST['lng2'];

$datetime = date("Y-d-m H:i:s", strtotime($datetime));

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

    //get num rows

    $apiUrl = 'https://maps.googleapis.com/maps/api/directions/json?origin='.$lat.','.$lng.'&destination='.$lat2.','.$lng2.'&waypoints='.$trajet['lat'].','.$trajet['lng'].'|'.$trajet['lat2'].','.$trajet['lng2'].'&key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo';
    $response = file_get_contents($apiUrl);
    $directions = json_decode($response, true);



    if ($directions['status'] === 'OK') {
        $distance = $directions['routes'][0]['legs'][2]['distance']['value'];
        $distance = $distance / 1000;

if ($distance <= 20) {
    if ($trajetInteressant === null || abs($distance) < $distancePlusInteressante) {
        $trajetInteressant = $trajet;
        $distancePlusInteressante = abs($distance);
    }
}
    } else {
        echo 'Erreur lors de la récupération du trajet.';
    }
}


if ($trajetInteressant !== null) {
    echo '<h2>Trajet intéressant :</h2>';
    echo 'Lieu de départ : '.$trajetInteressant['lieu_depart'].'<br>';
    echo 'Lieu d\'arrivée : '.$trajetInteressant['lieu_arrivee'].'<br>';
    echo 'Distance :'.round($trajetInteressant['km']).'km<br>';
    echo 'Temps de trajet : '. $trajetInteressant['duree'].'<br>';


    $sqls = "SELECT * FROM passager WHERE trajet_id = ?";
    $stmts = $dbh->prepare($sqls);
    $stmts->bind_param("i", $trajetInteressant['id']);
    $stmts->execute();
    $results = $stmts->get_result();
    $num_rows = $results->num_rows;

    echo 'Place restante :'.$num_rows.'/'.$trajetInteressant['place'].'<br>';

    if($num_rows == $trajetInteressant['place']){
        $complete = 'disabled';
    } else {
        $complete = '';
    }




    if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){
        echo '<button onclick="window.location.href=\'/reserv/'.$trajetInteressant['id'].'\'" '.$complete.'>S\'inscrire à ce trajet</button>';
    } else {
        echo '<button onclick="window.location.href=\'./connexion.php\'">Connectez-vous pour vous inscrire à ce trajet</button><br><br>';
    }

    $result->data_seek(0); 
    while ($trajet = $result->fetch_assoc()) {
        if ($trajet === $trajetInteressant) {
            continue;
        }

        $apiUrl = 'https://maps.googleapis.com/maps/api/directions/json?origin='.$lat.','.$lng.'&destination='.$lat2.','.$lng2.'&waypoints='.$trajet['lat'].','.$trajet['lng'].'|'.$trajet['lat2'].','.$trajet['lng2'].'&key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo';
        $response = file_get_contents($apiUrl);
        $directions = json_decode($response, true);

        

        if ($directions['status'] === 'OK') {

            $distance = $directions['routes'][0]['legs'][2]['distance']['value'];
            $distance = $distance / 1000;

            if($distance < 50) {
            echo '<br><br>';
            echo 'Lieu de départ : '.$trajet['lieu_depart'].'<br>';
            echo 'Lieu d\'arrivée : '.$trajet['lieu_arrivee'].'<br>';
            echo 'Temps de trajet : '. $trajet['duree'].'<br>';
            echo 'Distance :'.round($trajet['km']).'km<br>';

            $sqls = "SELECT * FROM passager WHERE trajet_id = ?";
            $stmts = $dbh->prepare($sqls);
            $stmts->bind_param("i", $trajet['id']);
            $stmts->execute();
            $results = $stmts->get_result();
            $num_rows = $results->num_rows;

            echo 'Place restante :'.$num_rows.'/'.$trajet['place'].'<br>';

            if($num_rows == $trajet['place']){
                $complete = 'disabled';
            } else {
                $complete = '';
            }
        
            if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){
                echo '<button onclick="window.location.href=\'/reserv/'.$trajet['id'].'\'" '.$complete.'>S\'inscrire à ce trajet</button>';
            } else {
                echo '<button onclick="window.location.href=\'./connexion.php\'">Connectez-vous pour vous inscrire à ce trajet</button><br><br>';
            }


            echo '<br>';
        }

        } else {
            echo 'Erreur lors de la récupération du trajet.';
            break;
        }
    }
} else {
    echo 'Aucun trajet trouvé.';
}

?>