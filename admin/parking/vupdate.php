<?php

session_start();
$id = $_POST['id'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$nom = $_POST['name'];

require_once '../../assets/php/lib.php';


if(!isset($id)) {
    header("Location: ../index.php");
    exit();
}


if(empty($lat) || empty($lng) || empty($nom)) {
    $_SESSION['error'] = "Veuillez remplir tous les champs";
    header("Location: ../g_parking.php");
    exit();
}

if(!is_numeric($lat) || !is_numeric($lng)) {
    $_SESSION['error'] = "Veuillez entrer des coordonnées valides";
    header("Location: ../g_parking.php");
    exit();
}

if(!preg_match("/^[a-zA-Z0-9\s]*$/", $nom)) {
    $_SESSION['error'] = "Veuillez entrer un nom valide";
    header("Location: ../g_parking.php");
    exit();
}


$dbh = connect();


// Check if parking exists
$sql = "SELECT * FROM parking WHERE name = ? AND id != ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("si", $nom, $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    $_SESSION['error'] = "Ce parking existe déjà";
    header("Location: ../g_parking.php");
    exit();
}


$sql = "UPDATE parking SET lat = ?, lng = ?, name = ? WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ddsi", $lat, $lng, $nom, $id);
$stmt->execute();

$_SESSION['error'] = "Parking modifié avec succès";
header("Location: ../g_parking.php");
exit();