<?php

session_start();

$lieu_depart = $_POST['depart'];
$lieu_arrivee = $_POST['arrivee'];
$date = $_POST['date'];
$lat1 = $_POST['lat1'];
$lng1 = $_POST['long1'];
$lat2 = $_POST['lat2'];
$lng2 = $_POST['long2'];
$distance = $_POST['distance'];
$temps = $_POST['duree'];
$place = $_POST['place'];
$co2 = $_POST['co2'];
$id = $_POST['id'];

if(empty($lieu_depart) || empty($lieu_arrivee) || empty($date) || empty($lat1) || empty($lng1) || empty($lat2) || empty($lng2) || empty($distance) || empty($temps) || empty($place) || empty($co2)) {
    $_SESSION['error'] = "Veuillez remplir tous les champs.";
    exit();
}

if(!is_numeric($lat1) || !is_numeric($lng1) || !is_numeric($lat2) || !is_numeric($lng2) || !is_numeric($distance) || !is_numeric($temps) || !is_numeric($place)) {
    $_SESSION['error'] = "Vos coordonnées ne sont pas valides";
    header("Location: ../g_trajet.php");
    exit();
}

if($date < 0) {
    $_SESSION['error'] = "La date et l'heure ne sont pas valides.";
    header('Location: ../g_trajet.php');
    exit;
}

$timestamp = strtotime($date);
$now = time();


if ($timestamp === false) {
    $_SESSION['error'] = "La date et l'heure ne sont pas valides.";
    header('Location: ../g_trajet.php');
    exit;
} else {

}

if ($timestamp < $now) {
    $_SESSION['error'] = "La date et l'heure semblent être dans le passé.";
    header('Location: ../g_trajet.php');
    exit;
} else {

}

if ($place < 1 || $place > 7) {
    $_SESSION['error'] = "Le nombre de place doit être compris entre 1 et 7.";
    header('Location: ../g_trajet.php');
    exit;
} else {

}

if ($distance < 0) {
    $_SESSION['error'] = "La distance ne peut pas être négative.";
    header('Location: ../g_trajet.php');
    exit;
} else {

}

if ($temps < 0) {
    $_SESSION['error'] = "Le temps ne peut pas être négatif.";
    header('Location: ../g_trajet.php');
    exit;
} else {

}

if ($co2 < 0) {
    $_SESSION['error'] = "Le co2 ne peut pas être négatif.";
    header('Location: ../g_trajet.php');
    exit;
} else {

}

require_once '../../assets/php/lib.php';

$dbh = connect();


$sql = 'UPDATE trajet SET lieu_depart = ?, lieu_arrivee = ?, date = ?, lat = ?, lng = ?, lat2 = ?, lng2 = ?, km = ?, duree = ?, place = ?, co2 = ? WHERE id = ?';
$stmt = $dbh->prepare($sql);
$stmt->bind_param('sssddddddsdi', $lieu_depart, $lieu_arrivee, $date, $lat1, $lng1, $lat2, $lng2, $distance, $temps, $place, $co2, $id);
$stmt->execute();
$stmt->close();

$_SESSION['error'] = "Le trajet a bien été modifié.";
header('Location: ../g_trajet.php');
