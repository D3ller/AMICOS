<?php

$id=$_GET['id'];

if(!isset($id)) {
    $_SESSION['error'] = "Vous n'avez pas sélectionné d'utilisateur";
    header('Location: ../g_user.php');
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
<a href="../g_user.php">Retour aux utilisateurs</a>

<?php


require_once '../../assets/php/lib.php';

$dbh = connect();

$sql = "SELECT * FROM profil WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($result->num_rows === 0) {
    $_SESSION['error'] = "Cet utilisateur n'existe pas";
    header('Location: ../g_user.php');
    exit();
}

echo '<h2>Modifier un utilisateur</h2>';
echo '<form id="update_user" action="./vupdate.php" method="post">';
echo '<input name="id" type="hidden" id="id" value="'.$user['id'].'">';

echo '<div class="updt">';
echo '<label for="email">Email</label>';
echo '<input name="email" type="email" id="email" value="'.$user['email'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label for="nom">Nom</label>';
echo '<input name="nom" type="text" id="nom" value="'.$user['nom'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label for="prenom">Prénom</label>';
echo '<input name="prenom" type="text" id="prenom" value="'.$user['prenom'].'">';
echo '</div>';

echo '<div class="updt">';
echo '<label for="groups">Groupe</label>';
echo '<select name="groups" id="groups">';
echo '<option value="A" '.($user['groups'] === 'A' ? 'selected' : '').'>A</option>';
echo '<option value="B" '.($user['groups'] === 'B' ? 'selected' : '').'>B</option>';
echo '<option value="C" '.($user['groups'] === 'C' ? 'selected' : '').'>C</option>';
echo '<option value="D" '.($user['groups'] === 'D' ? 'selected' : '').'>D</option>';
echo '<option value="E" '.($user['groups'] === 'E' ? 'selected' : '').'>E</option>';
echo '<option value="F" '.($user['groups'] === 'F' ? 'selected' : '').'>F</option>';
echo '</select>';
echo '</div>';

echo '<div class="updt2">';
echo '<label for="description">Description</label>';
echo '<textarea name="description" row="15" col="30" id="description">'.$user['description'].'</textarea>';
echo '<button id="update">Modifier</button>';
echo '</div>';
echo '</form>';

?>

</main>

</body>
</html>