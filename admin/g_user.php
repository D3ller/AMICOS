<?php


session_start();




require_once('../assets/php/lib.php');

$dbh = connect();

if (isset($_SESSION['error'])) {
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}


$sql = "SELECT * from profil";

$stmt = $dbh->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();

while ($user = $result->fetch_assoc()) {
    echo "<p>".$user['prenom']." ".$user['nom']." - TP ".$user['groups']."</p>";
    echo "<a href='./user/delete.php?id=".$user['id']."'>Supprimer</a>";
    echo " | ";
    echo "<a href='./user/update.php?id=".$user['id']."'>Modifier</a>";
    echo "<br>";
}



?>