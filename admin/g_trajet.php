<?php

session_start();

require_once('../assets/php/lib.php');

if (isset($_SESSION['error'])) {
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}

echo '<a href="./admin.php">Retour au home</a><br><br>';

$dbh = connect();

$sql = "SELECT * from trajet";

$stmt = $dbh->prepare($sql);

$stmt->execute();

$result = $stmt->get_result();

while ($trajet = $result->fetch_assoc()) {

    $trajet['date'] = date('d/m/Y H:i', strtotime($trajet['date']));

    echo '<div class="trajet">';
    echo '<div class="trajet-info">';
    echo '<h2>'.$trajet['id']. '. ' . $trajet['lieu_depart'] . ' - ' . $trajet['lieu_arrivee'] . '</h2>';
    echo '<p>' . $trajet['date'] . '</p>';
    echo '<p>' . $trajet['place'] . ' places</p>';
    echo '<a href="./trajet/delete.php?id=' . $trajet['id'] . '">Supprimer</a><br>';
    echo '<a href="./trajet/update.php?id=' . $trajet['id'] . '">Modifier</a>';    
    echo '</div>';
    echo '<hr><br><br>';

}

