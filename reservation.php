<?php
session_start();

if(!isset($_SESSION['AMIID']) || !isset($_SESSION['AMIMAIL'])) {
    $_SESSION['error'] = "Vous n'avez pas le droit de réserver un trajet sans être connecté";
    header('Location: ../connexion.php');
    exit();

}

$id = $_GET['id'];

if(!isset($id)) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver un trajet sans avoir sélectionné un trajet";
    header('Location: ../');
    exit();

}

require_once './assets/php/lib.php';

$dbh = connect();

$sql = "SELECT * FROM trajet WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$trajet = $result->fetch_assoc();

if($result->num_rows == 0) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver un trajet qui n'existe pas";
    header('Location: ../');
    exit();

}

$sqluser = "SELECT * FROM profil WHERE email = ? AND id = ?";
$stmtuser = $dbh->prepare($sqluser);
$stmtuser->bind_param("ss", $_SESSION['AMIMAIL'], $_SESSION['AMIID']);
$stmtuser->execute();
$resultuser = $stmtuser->get_result();
$user = $resultuser->fetch_assoc();

if($trajet['conducteur_id'] == $user['id']) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver votre propre trajet";
    header('Location: ../');
    exit();

}

$sql = "SELECT * FROM passager WHERE user_id = ? AND trajet_id = ?";    
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ii", $user['id'], $trajet['id']);
$stmt->execute();
$result = $stmt->get_result();
$passager = $result->fetch_assoc();

if($result->num_rows > 0) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver un trajet que vous avez déjà réservé";
    header('Location: ../');
    exit();

}

$sql = "SELECT COUNT(*) AS num_rows FROM passager WHERE trajet_id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $trajet['id']);
$stmt->execute();
$result = $stmt->get_result();
$passagers = $result->fetch_assoc();

if($passagers['num_rows'] >= $trajet['place']) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver un trajet qui est complet";
    header('Location: ../');
    exit();
}

$sql = "INSERT INTO passager (user_id, trajet_id) VALUES (?, ?)";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ii", $user['id'], $trajet['id']);
$stmt->execute();

$_SESSION['error'] = "Vous avez réservé un trajet";
header('Location: ../profil');
exit();
?>