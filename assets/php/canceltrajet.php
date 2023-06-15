<?php
session_start();
require_once './assets/php/lib.php';
$dbh = connect();

ini_set('display_errors', 0);

$id = $_GET['id'];
$type = $_GET['type'];

if(!isset($_SESSION['AMIMAIL']) || !isset($_SESSION['AMIID'])) {
    header('Location: /connexion.php');
    $_SESSION['error'] = "Vous devez être connecté pour annuler un trajet";
    exit();
}

if(!isset($id) || !isset($type)) {
    header('Location: /mesreservations.php');
    $_SESSION['error'] = "Vous devez sélectionner un trajet pour l'annuler";
    exit();
}

if($type == "Conducteur") {
    $sql = "SELECT * FROM trajet WHERE id = ? AND conducteur_id = ? WHERE date > NOW()";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("ii", $id, $_SESSION['AMIID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $trajet = $result->fetch_assoc();

    if($result->num_rows == 0) {
        header('Location: /mesreservations.php');
        $_SESSION['error'] = "Vous ne pouvez pas annuler un trajet qui n'existe pas ou qui est passé";
        exit();
    }

    $sql = "DELETE FROM trajet WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $sql = "DELETE FROM passager WHERE trajet_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header('Location: /mesreservations.php');
    $_SESSION['error'] = "Votre trajet a bien été annulé, les passagers ont été prévenus";
    exit();
}

