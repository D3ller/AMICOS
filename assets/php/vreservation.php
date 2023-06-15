<?php
session_start();

error_reporting(0);

require_once './lib.php';

if(!isset($_SESSION['AMIMAIL']) || !isset($_SESSION['AMIID'])) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver un trajet sans être connecté";    
    header('Location: /../../');
    exit();
}

$id = $_GET['id'];

if(!isset($id)) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver un trajet sans avoir sélectionné un trajet";
    header('Location: /../../');
    exit();

}

$dbh = connect();

$sql = "SELECT * FROM trajet WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$trajet = $result->fetch_assoc();

if($result->num_rows == 0) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver un trajet qui n'existe pas";
    header('Location: /../../');
    exit();

}

if($trajet['conducteur_id'] == $_SESSION['AMIID']) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver votre propre trajet";
    header('Location: /../../');
    exit();

}

$sql = "SELECT * FROM passager WHERE user_id = ? AND trajet_id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ii", $_SESSION['AMIID'], $trajet['id']);
$stmt->execute();
$result = $stmt->get_result();
$passager = $result->fetch_assoc();

if($result->num_rows > 0) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver un trajet que vous avez déjà réservé";
    header('Location: /../../');
    exit();

}

$sql = "SELECT * FROM passager WHERE trajet_id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $trajet['id']);
$stmt->execute();
$result = $stmt->get_result();
$passagers = $result->fetch_assoc();

if($result->num_rows >= $trajet['place']) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver un trajet qui est complet";
    header('Location: /../../');
    exit();

}


$sql = "INSERT INTO passager (user_id, trajet_id) VALUES (?, ?)";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ii", $_SESSION['AMIID'], $trajet['id']);
$stmt->execute();

$_SESSION['error'] = '<div class="errorred ">
<div class="errorunderred valided">
    <div class="errorredcaracter validedcaracter">
    </div>

</div>
<h1>Validé !</h1>
<p>Votre trajet a bien été réservé !
</p>
</div>';
header('Location: /../../');
exit();

?>