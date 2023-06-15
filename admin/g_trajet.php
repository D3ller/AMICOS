<?php

session_start();

require_once('../assets/php/lib.php');

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Administration</title>
</head>
<body>


<main>
<img src="https://portfolio.karibsen.fr/assets/img/rosetext.svg" alt="Logo">


<h1>Gestion des trajets</h1>

<a href="./admin.php">Retour à l'accueil</a>

<?php

if (isset($_SESSION['error'])) {
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}

$dbh = connect();
echo "<div class='tab-gen'>";

$sql = "SELECT * from trajet";

$stmt = $dbh->prepare($sql);

$stmt->execute();

$result = $stmt->get_result();

while ($trajet = $result->fetch_assoc()) {
    echo '<div class="tab-modif">';

    $trajet['date'] = date('d/m/Y H:i', strtotime($trajet['date']));

    echo '<h2>'. $trajet['lieu_depart'] . ' - ' . $trajet['lieu_arrivee'] . '</h2>';
    echo '<p>' . $trajet['date'] . '</p>';
    echo '<p>' . $trajet['place'] . ' places</p>';
    echo '<div class="tab-modif-coord">';
    echo '<a href="./trajet/delete.php?id=' . $trajet['id'] . '">Supprimer</a><br>';
    echo '<a href="./trajet/update.php?id=' . $trajet['id'] . '">Modifier</a>';    
    echo "</div>";
    echo "</div>";

}
echo  "</div>";
?>
</main>
    
</body>
</html>