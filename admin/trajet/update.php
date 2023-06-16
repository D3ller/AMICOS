<?php

$id=$_GET['id'];

if(!isset($id)) {
    $_SESSION['error'] = "Vous n'avez pas sélectionné de trajet";
    header('Location: ../g_trajet.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Administration</title>
</head>
<body>


<main>
<img src="https://portfolio.karibsen.fr/assets/img/rosetext.svg" alt="Logo">


<h1>Gestion des utilisateurs</h1>

<a href="../admin.php">Retour à l'accueil</a>
<a href="../g_trajet.php">Retour aux trajet</a>

<?php

require_once '../../assets/php/lib.php';

$dbh = connect();

$sql = "SELECT * FROM trajet WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$trajet = $result->fetch_assoc();

if($result->num_rows === 0) {
    $_SESSION['error'] = "Ce trajet n'existe pas";
    header('Location: ../g_trajet.php');
    exit();
}

echo '<h2>Modifier un trjaet</h2>';
echo '<form id="update_user" action="vupdate.php" method="post">';
echo '<input type="hidden" name="id" value="'.$trajet['id'].'">';

echo '<div class="updt">';
echo '<label for="depart">Départ</label>';
echo '<input type="text" name="depart" value="'.$trajet['lieu_depart'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label for="arrivee">Arrivée</label>';
echo '<input type="text" name="arrivee" value="'.$trajet['lieu_arrivee'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label for="date">Date</label>';
echo '<input type="datetime-local" name="date" value="'.$trajet['date'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label for="heure">Latitude 1</label>';
echo '<input type="text" name="lat1" value="'.$trajet['lat'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label for="heure">Longitude 1</label>';
echo '<input type="text" name="long1" value="'.$trajet['lng'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label for="heure">Latitude 2</label>';
echo '<input type="text" name="lat2" value="'.$trajet['lat2'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label for="heure">Longitude 2</label>';
echo '<input type="text" name="long2" value="'.$trajet['lng2'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label> Distance </label>';
echo '<input type="text" name="distance" value="'.$trajet['km'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label> Durée </label>';
echo '<input type="text" name="duree" value="'.$trajet['duree'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label> CO2 </label>';
echo '<input type="text" name="co2" value="'.$trajet['co2'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label> Place </label>';
echo '<select name="place">';
for($i=1; $i<=7; $i++) {
    if($i == $trajet['place']) {
        echo '<option value="'.$i.'" selected>'.$i.'</option>';
    } else {
        echo '<option value="'.$i.'">'.$i.'</option>';
    }
}
echo '</select>';
echo '</div>';

echo '<div class="updt">';
echo '<input type="submit" value="Modifier">';
echo '</div>';
echo '</form>';

?>

</main>
</body>
</html>






