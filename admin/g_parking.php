<?php

session_start();

require_once('../assets/php/lib.php');

if (isset($_SESSION['error'])) {
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}

echo '<a href="./admin.php">Retour au home</a><br><br>';
echo '<a href="./parking/add.php">Ajouter un parking</a><br><br>';

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


<?php

    $dbh = connect();

    $sql = "SELECT * from parking";

    $stmt = $dbh->prepare($sql);

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows == 0) {
        echo '<p>Aucun parking disponible</p>';
        exit();
    }

    while ($parking = $result->fetch_assoc()) {
        echo $parking['name'];
        echo '<div class="tab-modif">';
        echo '<a href="./parking/update.php?id=' . $parking['id'] . '">Modifier</a>';
        echo '<a href="./parking/delete.php?id=' . $parking['id'] . '">Supprimer</a>';
        echo '<a href="https://www.google.com/maps?q='.$parking['lat'].','.$parking['lng'].'">Voir</a>';
        echo '</div>';

    }

    ?>
</main>
    
</body>
</html>