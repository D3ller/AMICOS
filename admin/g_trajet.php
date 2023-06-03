<?php

session_start();

require_once('../assets/php/lib.php');

$dbh = connect();

$sql = "SELECT * from trajet";

$stmt = $dbh->prepare($sql);

$stmt->execute();

$result = $stmt->get_result();

while ($trajet = $result->fetch_assoc()) {
    echo '<div class="trajet">';
    echo '<div class="trajet-info">';
    echo '<h2>' . $trajet['depart'] . ' - ' . $trajet['arrivee'] . '</h2>';
    echo '<p>' . $trajet['date'] . '</p>';
    echo '<p>' . $trajet['heure'] . '</p>';
    echo '<p>' . $trajet['prix'] . '€</p>';
    echo '<p>' . $trajet['nbplace'] . ' places</p>';
    echo '</div>';
}

