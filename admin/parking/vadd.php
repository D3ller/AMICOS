<?php
session_start();

require_once '../../assets/php/lib.php';


$lat = $_POST['lat'];
$lng = $_POST['lng'];
$name = $_POST['name'];

if(empty($lat) || empty($lng) || empty($name)) {
    $_SESSION['error'] = "Veuillez remplir tous les champs";
    header("Location: ../g_parking.php");
    exit();
}

if(!is_numeric($lat) || !is_numeric($lng)) {
    $_SESSION['error'] = "Veuillez entrer des coordonnées valides";
    header("Location: ../g_parking.php");
    exit();
}

if(!preg_match("/^[a-zA-Z0-9\s]*$/", $name)) {
    $_SESSION['error'] = "Veuillez entrer un nom valide";
    header("Location: ../g_parking.php");
    exit();
}


$dbh = connect();

$sql = "SELECT * FROM parking WHERE name = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();
$numRows = $result->num_rows;

if($numRows === 0) {

} else {
    $_SESSION['error'] = "Ce parking existe déjà";
    header("Location: ../g_parking.php");
    exit();
}


$name = htmlspecialchars($name);
$name = mysqli_real_escape_string($dbh, $name);

$sql = "INSERT INTO parking (name, lat, lng) VALUES (?, ?, ?)";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("sdd", $name, $lat, $lng);
$stmt->execute();

$_SESSION['error'] = "Parking ajouté avec succès";
header("Location: ../g_parking.php");