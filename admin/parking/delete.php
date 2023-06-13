<?php
session_start();

$id = $_GET['id'];


require_once '../../assets/php/lib.php';

if(!isset($id)) {
$_SESSION['error'] = "Vous devez être connecté pour accéder à cette page";
header('Location: ../g_parking.php');
exit();
}

$dbh = connect();

$sql = "SELECT * FROM parking WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$parking = $result->fetch_assoc();

if($result->num_rows == 0) {
    $_SESSION['error'] = "Ce parking n'existe pas";
    header('Location: ../g_parking.php');
    exit();
}

$pkname = $parking['name'];

$sql = "DELETE FROM parking WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$_SESSION['error'] = "Le parking $pkname a bien été supprimé";
header('Location: ../g_parking.php');
exit();
