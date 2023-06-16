<?php

$id=$_GET['id'];

if(!isset($id)) {
    $_SESSION['error'] = "Vous n'avez pas sélectionné de parking";
    header('Location: ../g_parking.php');
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

$dbh = connect();

$sql = "SELECT * FROM parking WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$parking = $result->fetch_assoc();

if($result->num_rows == 0) {
    $_SESSION['error'] = "Ce parking n'existe pas";
    header('Location: ../g_parking.php');
    exit();
}

?>
    
    <form id='update_user' action="./vupdate.php" method="post">
        <input type="hidden" name="id" value="<?php echo $parking['id'] ?>">

        <div class="updt">
            <label for="name">Nom</label>
        <input type="text" name="name" value="<?php echo $parking['name'] ?>">
        </div>

        <div class="updt">
            <label for="address">Latitude</label>
        <input type="text" name="lat" value="<?php echo $parking['lat'] ?>">
        </div>

        <div class="updt">
            <label for="address">Longitude</label>
        <input type="text" name="lng" value="<?php echo $parking['lng'] ?>">
        </div>

        <div class="updt">
        <input type="submit" value="Modifier">
        </div>
    </form>
</body>
</html>