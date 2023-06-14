<?php 

session_start();

require_once './assets/php/lib.php';

if(!isset($_SESSION['AMIMAIL']) || !isset($_SESSION['AMIID'])) {
    $_SESSION['error'] = "Vous ne pouvez pas regarder vos trajets sans être connecté";    
    header('Location: /../../');
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes réservations</title>
    <link type='text/css' rel='stylesheet' href='./assets/css/header-footer.css'>
    <link type='text/css' rel='stylesheet' href='./assets/css/mesreservations.css'>
</head>
<body>

<?php
require_once 'header.php';
require_once 'customnav.php';
?>

<main>
<?php

$dbh = connect();
$sql = "SELECT * FROM trajet WHERE conducteur_id = ? AND date > NOW() ORDER BY date DESC";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("s", $_SESSION['AMIID']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo '<h2 id="conducteur">En tant que conducteur</h2>';

    setlocale(LC_TIME, 'fr_FR');
    $row['date'] = new DateTime($row['date']);
    $row['date'] = strftime('%A %e %B à %H:%M', $row['date']->getTimestamp());
    $row['date'] = ucfirst($row['date']);

    $minutes = $row['duree'] * 60;
    $hours = floor($minutes / 60);
    $minutes = $minutes - ($hours * 60);
    $minutes = round($minutes / 60 * 60);
    
    $minutes = sprintf("%02d", $minutes);
    
    $row['duree'] = $hours . 'h' . $minutes;

    $sql = "SELECT * FROM profil WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("s", $row['conducteur_id']);
    $stmt->execute();
    $result2 = $stmt->get_result();
    $conducteur = $result2->fetch_assoc();

    $sqlcount = "SELECT COUNT(*) FROM passager WHERE trajet_id = ?";
    $stmtcount = $dbh->prepare($sqlcount);
    $stmtcount->bind_param("s", $row['id']);
    $stmtcount->execute();
    $resultcount = $stmtcount->get_result();
    $count = $resultcount->fetch_assoc();


    
    echo '<div class="trajet">';
    echo '<div class="trajet-info">';
    echo '<div class="trajet-conducteur">';
    echo '<img src="' . $conducteur["profil-picture"] . '" alt="voiture">';
    echo '<div class="trajet-conducteur-info">';
    echo '<p class="trajet-date">' . $row['date'] . '</p>';
    echo '<p class="trajet-depart">' . $row['lieu_depart'] . '</p>';
    echo '<p class="trajet-arrivee">' . $row['lieu_arrivee'] . '</p>';
    echo '</div>';
    echo '</div>';
    echo '<details class="trajet-details">';
    echo '<summary>Plus d\'informations</summary>';
    echo '<p class="trajet-voiture">' . $conducteur['voiture'] . '</p>';
    echo '<p class="trajet-duration">' . $row['duree'] . '</p>';
    echo '<p class="trajet-km">' . $row['km'] . ' km</p>';
    echo '<details class="trajet-details one">';
    echo '<summary>Places '. $count['COUNT(*)']. '/' . $row['place'] . '</summary>';
    $sql = "SELECT * FROM passager WHERE trajet_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("s", $row['id']);
    $stmt->execute();
    $result2 = $stmt->get_result();
    while ($row2 = $result2->fetch_assoc()) {
        $sql = "SELECT * FROM profil WHERE id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bind_param("s", $row2['user_id']);
        $stmt->execute();
        $result3 = $stmt->get_result();
        $passager = $result3->fetch_assoc();
        echo '<p class="trajet-passager">' . $passager['prenom'] . ' ' . $passager['nom'] . '</p>';
    }
    echo '</div>';
    echo '</div>';
}

//passager

$sql = "SELECT passager.*, trajet.date
FROM passager
INNER JOIN trajet ON passager.trajet_id = trajet.id
WHERE passager.user_id = ? AND trajet.date > NOW()
ORDER BY trajet.date DESC;
";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("s", $_SESSION['AMIID']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {

    $sql = "SELECT * FROM trajet WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("s", $row['trajet_id']);
    $stmt->execute();
    $result2 = $stmt->get_result();
    $trajet = $result2->fetch_assoc();


    echo '<h2 id="conducteur">En tant que passager</h2>';

    setlocale(LC_TIME, 'fr_FR');
    $trajet['date'] = new DateTime($trajet['date']);
    $trajet['date'] = strftime('%A %e %B à %H:%M', $trajet['date']->getTimestamp());
    $trajet['date'] = ucfirst($trajet['date']);

    $minutes = $trajet['duree'] * 60;
    $hours = floor($minutes / 60);
    $minutes = $minutes - ($hours * 60);
    $minutes = round($minutes / 60 * 60);
    
    $minutes = sprintf("%02d", $minutes);
    
    $trajet['duree'] = $hours . 'h' . $minutes;

    $sql = "SELECT * FROM profil WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("s", $trajet['conducteur_id']);
    $stmt->execute();
    $result2 = $stmt->get_result();
    $conducteur = $result2->fetch_assoc();

    $sqlcount = "SELECT COUNT(*) FROM passager WHERE trajet_id = ?";
    $stmtcount = $dbh->prepare($sqlcount);
    $stmtcount->bind_param("s", $trajet['id']);
    $stmtcount->execute();
    $resultcount = $stmtcount->get_result();
    $count = $resultcount->fetch_assoc();


    
    echo '<div class="trajet">';
    echo '<div class="trajet-info">';
    echo '<div class="trajet-conducteur">';
    echo '<img src="' . $conducteur["profil-picture"] . '" alt="voiture">';
    echo '<div class="trajet-conducteur-info">';
    echo '<p class="trajet-date">' . $trajet['date'] . '</p>';
    echo '<p class="trajet-depart">' . $trajet['lieu_depart'] . '</p>';
    echo '<p class="trajet-arrivee">' . $trajet['lieu_arrivee'] . '</p>';
    echo '</div>';
    echo '</div>';
    echo '<details class="trajet-details">';
    echo '<summary>Plus d\'informations</summary>';
    echo '<p class="trajet-voiture">' . $conducteur['voiture'] . '</p>';
    echo '<p class="trajet-duration">' . $trajet['duree'] . '</p>';
    echo '<p class="trajet-km">' . $trajet['km'] . ' km</p>';
    echo '<details class="trajet-details one">';
    echo '<summary>Places '. $count['COUNT(*)']. '/' . $trajet['place'] . '</summary>';
    $sql = "SELECT * FROM passager WHERE trajet_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("s", $trajet['id']);
    $stmt->execute();
    $result2 = $stmt->get_result();
    while ($row2 = $result2->fetch_assoc()) {
        $sql = "SELECT * FROM profil WHERE id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bind_param("s", $row2['user_id']);
        $stmt->execute();
        $result3 = $stmt->get_result();
        $passager = $result3->fetch_assoc();
        echo '<p class="trajet-passager">' . $passager['prenom'] . ' ' . $passager['nom'] . '</p>';
    }
    echo '</div>';
    echo '</div>';

}

?>
</main>
    
</body>
</html>