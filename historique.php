<?php

session_start();

require_once('./assets/php/lib.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type='text/css' rel='stylesheet' href='/assets/css/historique.css'>
    <link type='text/css' rel='stylesheet' href='/assets/css/header-footer.css'>
    <title>Document</title>
</head>
<body>


<?php
require_once('customnav.php');

$dbh = connect();

$sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

require_once('customnav.php');


$sql = "SELECT * FROM trajet WHERE conducteur_id = ? AND date < NOW() ORDER BY date DESC";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("s", $user['id']);
    $stmt->execute();

    $result = $stmt->get_result();
    $number = $result->num_rows;

    $sql2 = 'SELECT * FROM passager INNER JOIN trajet ON passager.trajet_id = trajet.id WHERE passager.user_id = ? AND trajet.date < NOW() ORDER BY trajet.date ASC';
    $stmt2 = $dbh->prepare($sql2);
    $stmt2->bind_param("s", $user['id']);
    $stmt2->execute();

    $result2 = $stmt2->get_result();
    $number2 = $result2->num_rows;

    $number = $number + $number2;

    if($number == 0) {

    } else {
    }

    echo '<div id="card-lister">';
    while($trajet = $result->fetch_assoc()) {
        echo '<div class="card">';
        setlocale(LC_TIME, 'fr_FR');
        $trajet['date'] = new DateTime($trajet['date']);
        $trajet['date'] = strftime('%A %e %B à %H:%M', $trajet['date']->getTimestamp());
        $trajet['date'] = ucfirst($trajet['date']);
        

        $minutes = $trajet['duree'] * 60;
        $hours = floor($minutes / 60);
        $minutes = $minutes - ($hours * 60);
        $minutes = round($minutes / 60 * 60);

        $trajet['duree'] = $hours.'h'.$minutes;

        $sql2 = "SELECT * FROM profil WHERE id = ?";
        $stmt2 = $dbh->prepare($sql2);
        $stmt2->bind_param("s", $trajet['conducteur_id']);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $conducteur = $result2->fetch_assoc();

        $sql3 = "SELECT * FROM passager WHERE trajet_id = ?";
        $stmt3 = $dbh->prepare($sql3);
        $stmt3->bind_param("s", $trajet['id']);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $num_rows = $result3->num_rows;
        
        
        echo '<p id="date">'.$trajet['date'].'</p>';
        echo '<div class="card-img">';
        echo '<img src="' . $conducteur["profil-picture"] . '" alt="voiture">';
        echo '<div class="card-text">';
        echo '<h3>'. $conducteur["prenom"].' '.$conducteur["nom"].'</h3>';
        echo '<p>'.$trajet['lieu_depart'].' ➔ '.$trajet['lieu_arrivee'].'<br><span id="duration">Le trajet à durée '.$trajet['duree'].'</span></p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

    }

    while($trajet = $result2->fetch_assoc()) {
        echo '<div class="card">';
        $trajet['date'] = new DateTime($trajet['date']);
        $trajet['date'] = $trajet['date']->format('d/m/Y H:i');

        $minutes = $trajet['duree'] * 60;
        $hours = floor($minutes / 60);
        $minutes = $minutes - ($hours * 60);
        $minutes = round($minutes / 60 * 60);

        $trajet['duree'] = $hours.'h'.$minutes;

        $sql2 = "SELECT * FROM profil WHERE id = ?";
        $stmt2 = $dbh->prepare($sql2);
        $stmt2->bind_param("s", $trajet['conducteur_id']);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $conducteur = $result2->fetch_assoc();

        $sql3 = "SELECT * FROM passager WHERE trajet_id = ?";
        $stmt3 = $dbh->prepare($sql3);
        $stmt3->bind_param("s", $trajet['id']);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $num_rows = $result3->num_rows;
        
        

        echo '<h3>Conducteur:'. $conducteur["prenom"].' '.$conducteur["nom"].'</h3>';
        echo '<p> Lieu départ:'.$trajet['lieu_depart'].'</p>';
        echo '<p> Lieu arrivé:'.$trajet['lieu_arrivee'].'</p>';
        echo '<p> Date:'.$trajet['date'].'</p>';
        echo '<p>Durée: '.$trajet['duree'].' | KM: '.$trajet['km'].'km | CO2: '.$trajet['co2'].'kg</p>';
        echo '<p> Nombre de place:'.$num_rows. '/'.$trajet['place'].' passager(s)</p>';
        echo '</div>';

    }

?>

    
</body>
</html>