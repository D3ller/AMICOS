<?php

session_start();

require_once('./lib.php');

$lat = $_POST['lat'];
$lng = $_POST['lng'];
$lat2 = $_POST['lat2'];
$lng2 = $_POST['lng2'];

$depart = $_POST['depart'];
$arrivee = $_POST['arrivee'];

$datetime = $_POST['datetime'];
$co2 = $_GET['co2'];
$km = $_GET['km'];
$duree = $_GET['duree'];
$place = $_POST['place'];

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])) {

if(!is_numeric($km) || !is_numeric($co2) || !is_numeric($duree) || !is_numeric($lat) || !is_numeric($lng) || !is_numeric($lat2) || !is_numeric($lng2)) {
    
    $lng22 =     is_numeric($lng2);
    $_SESSION['error'] = "Il semblerait que vous ayez modifié les données de la page. Veuillez réessayer.";
    header('Location: /trajets.php');
    exit;
}

if($km < 0 || $co2 < 0 || $duree < 0) {
    $_SESSION['error'] = "Il semblerait que vous ayez modifié les données de la page. Veuillez réessayer.";
    header('Location: /trajets.php');
    exit;
}

if(!is_string($depart) || !is_string($arrivee)) {
    $_SESSION['error'] = "Au moins un des champs n'est pas valide. Veuillez réessayer.";
    header('Location: /trajets.php');
    exit;
}

if(strlen($depart) < 1 || strlen($arrivee) < 1) {
    $_SESSION['error'] = "Au moins un des champs n'est pas valide. Veuillez réessayer.";
    header('Location: /trajets.php');
    exit;
}

if($datetime < 0) {
    $_SESSION['error'] = "La date et l'heure ne sont pas valides.";
    header('Location: /trajets.php');
    exit;
}

$timestamp = strtotime($datetime);
$now = time();


if ($timestamp === false) {
    $_SESSION['error'] = "La date et l'heure ne sont pas valides.";
    header('Location: /trajets.php');
    exit;
} else {

}

if ($timestamp < $now) {
    $_SESSION['error'] = "La date et l'heure semblent être dans le passé.";
    header('Location: /trajets.php');
    exit;
} else {

}

if($place < 1) {
    $_SESSION['error'] = "Il ne peux pas y avoir moins d'une place disponible.";
    header('Location: /trajets.php');
    exit;
}

if(!is_numeric($place)) {
    $_SESSION['error'] = "Le nombre de place doit être un nombre.";
    header('Location: /trajets.php');
    exit;
}

if($place > 7) {
    $_SESSION['error'] = "Il ne peux pas y avoir plus de 9 places disponibles.";
    header('Location: /trajets.php');
    exit;
}

$dbh = connect();

$sql = "SELECT * FROM profil WHERE email = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("s", $_SESSION['AMIMAIL']);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();


$sql = "INSERT INTO trajet (conducteur_id, duree, km, co2, lat, lng, lat2, lng2, lieu_depart, lieu_arrivee, date, place) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("iddddddsssss", $user['id'], $duree, $km, $co2, $lat, $lng, $lat2, $lng2, $depart, $arrivee, $datetime, $place);
$stmt->execute();

$_SESSION['error'] = "Votre trajet a bien été ajouté";
header('Location: /profil.php');
exit;

} else {
    $_SESSION['error'] = "Vous devez être connecté pour effectuer cette action";
    header('Location: /connexion.php');
    exit;
}

