<?php

$id=$_GET['id'];

if(!isset($id)) {
    $_SESSION['error'] = "Vous n'avez pas sélectionné d'utilisateur";
    header('Location: ../g_trajet.php');
    exit();
}


require_once '../../assets/php/lib.php';

$dbh = connect();

$sql = "SELECT * FROM trajet WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$trajet = $result->fetch_assoc();

if($result->num_rows === 0) {
    $_SESSION['error'] = "Cet utilisateur n'existe pas";
    header('Location: ../g_trajet.php');
    exit();
}

echo '<h2>Modifier un trjaet</h2>';
echo '<form action="vupdate.php" method="post">';
echo '<input type="hidden" name="id" value="'.$trajet['id'].'">';

echo '<label for="depart">Départ</label>';
echo '<input type="text" name="depart" value="'.$trajet['lieu_depart'].'">';
echo '<br>';
echo '<label for="arrivee">Arrivée</label>';
echo '<input type="text" name="arrivee" value="'.$trajet['lieu_arrivee'].'">';
echo '<br>';

echo '<label for="date">Date</label>';
echo '<input type="datetime-local" name="date" value="'.$trajet['date'].'">';
echo '<br>';

echo '<label for="heure">Latitude 1</label>';
echo '<input type="text" name="lat1" value="'.$trajet['lat'].'">';
echo '<br>';

echo '<label for="heure">Longitude 1</label>';
echo '<input type="text" name="long1" value="'.$trajet['lng'].'">';
echo '<br>';

echo '<label for="heure">Latitude 2</label>';
echo '<input type="text" name="lat2" value="'.$trajet['lat2'].'">';
echo '<br>';

echo '<label for="heure">Longitude 2</label>';
echo '<input type="text" name="long2" value="'.$trajet['lng2'].'">';
echo '<br>';

echo '<label> Distance </label>';
echo '<input type="text" name="distance" value="'.$trajet['km'].'">';
echo '<br>';

echo '<label> Durée </label>';
echo '<input type="text" name="duree" value="'.$trajet['duree'].'">';
echo '<br>';

echo '<label> CO2 </label>';
echo '<input type="text" name="co2" value="'.$trajet['co2'].'">';
echo '<br>';

//select place allant de 1 a 7
echo '<label> Place </label>';
echo '<select name="place">';
for($i=1; $i<=7; $i++) {
    if($i == $trajet['place']) {
        echo '<option value="'.$i.'" selected>'.$i.'</option>';
    } else {
        echo '<option value="'.$i.'">'.$i.'</option>';
    }
}




echo '<input type="submit" value="Modifier">';
echo '</form>';

?>






