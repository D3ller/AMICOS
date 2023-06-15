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


<h1>Gestion des utilisateurs</h1>

<a href="./admin.php">Retour à l'accueil</a>

<?php

$dbh = connect();

if (isset($_SESSION['error'])) {
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}

echo "<div class='tab-gen'>";

$sql = "SELECT * from profil";

$stmt = $dbh->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();

while ($user = $result->fetch_assoc()) {
    echo '<div class="tab-modif">';
    echo "<p>".$user['prenom']." ".$user['nom']." - TP ".$user['groups']."</p>";
    echo '<div class="tab-modif-coord">';
    echo "<a href='./user/delete.php?id=".$user['id']."'>Supprimer</a>";
    echo "<a href='./user/update.php?id=".$user['id']."'>Modifier</a>";
    echo "</div>";
    echo "</div>";

}

echo  "</div>";



?>
</main>
    
    </body>
    </html>