<?php

$id=$_GET['id'];

if(!isset($id)) {
    $_SESSION['error'] = "Vous n'avez pas sélectionné d'utilisateur";
    header('Location: ../g_user.php');
    exit();
}


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
echo '<label for="email">Email</label>';
echo '<input name="email" type="email" id="email" value="'.$user['email'].'">';
echo '<label for="nom">Nom</label>';
echo '<input name="nom" type="text" id="nom" value="'.$user['nom'].'">';
echo '<label for="prenom">Prénom</label>';
echo '<input name="prenom" type="text" id="prenom" value="'.$user['prenom'].'">';
echo '<label for="groups">Groupe</label>';
echo '<select name="groups" id="groups">';
echo '<option value="A" '.($user['groups'] === 'A' ? 'selected' : '').'>A</option>';
echo '<option value="B" '.($user['groups'] === 'B' ? 'selected' : '').'>B</option>';
echo '<option value="C" '.($user['groups'] === 'C' ? 'selected' : '').'>C</option>';
echo '<option value="D" '.($user['groups'] === 'D' ? 'selected' : '').'>D</option>';
echo '<option value="E" '.($user['groups'] === 'E' ? 'selected' : '').'>E</option>';
echo '<option value="F" '.($user['groups'] === 'F' ? 'selected' : '').'>F</option>';
echo '</select>';
echo '<textarea name="description" id="description" cols="30" rows="10">'.$user['description'].'</textarea>';
echo '<button id="update">Modifier</button>';
echo '</form>';

?>