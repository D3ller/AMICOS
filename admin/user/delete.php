<?php

session_start();

require_once '../../assets/php/lib.php';

$id = $_GET['id'];

if(!isset($id)){
    $_SESSION['error'] = "Erreur lors de la suppression de l'utilisateur, aunucn id n'a été trouvé";
    header('Location: ../admin.php');
    exit();
}

$dbh = connect();
$sql = 'SELECT * FROM profil WHERE id = ?';
$stmt = $dbh->prepare($sql);
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$users = $user['prenom'].' '.$user['nom'];

$sql = 'DELETE FROM profil WHERE id = ?';
$stmt = $dbh->prepare($sql);
$stmt->bind_param('s', $id);
$stmt->execute();

$sql2 = 'DELETE FROM trajet WHERE conducteur_id = ?';
$stmt2 = $dbh->prepare($sql2);
$stmt2->bind_param('s', $id);
$stmt2->execute();

$sql3 = 'DELETE FROM passager WHERE user_id = ?';
$stmt3 = $dbh->prepare($sql3);
$stmt3->bind_param('s', $id);
$stmt3->execute();

$_SESSION['error'] = "L'utilisateur ".$users." a bien été supprimé";
header('Location: ../g_user.php');
exit();
