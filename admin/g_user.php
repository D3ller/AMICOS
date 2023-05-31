<?php


session_start();

require_once('../assets/php/lib.php');

$dbh = connect();

$sql = "Select * from profil";

$stmt = $dbh->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();

while ($user = $result->fetch_assoc()) {
    echo "<p>".$user['prenom']." ".$user['nom']."</p>";
    echo "<a href='./assets/php/delete.php?id=".$user['id']."'>Supprimer</a>";
    echo " | ";
    echo "<a href='./assets/php/update.php?id=".$user['id']."'>Modifier</a>";
    echo "<br>";
}