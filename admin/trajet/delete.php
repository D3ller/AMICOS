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
$sql = "SELECT * FROM trajet WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$trajet = $result->fetch_assoc();

if($result->num_rows == 0){
    $_SESSION['error'] = "Erreur lors de la suppression du trajet, aucun trajet n'a été trouvé";
    header('Location: ../g_trajet.php');
    exit();
}

$ids = $trajet['id'];

$sql = "DELETE FROM trajet WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("s", $ids);
$stmt->execute();

$sql2 = "DELETE FROM passager WHERE trajet_id = ?";
$stmt2 = $dbh->prepare($sql2);
$stmt2->bind_param("s", $ids);
$stmt2->execute();

$_SESSION['error'] = "Le trajet a bien été supprimé ainsi que les passagers associés";
header('Location: ../g_trajet.php');
exit();

?>