<?php

session_start();

$email = $_POST['email'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$groups = $_POST['groups'];
$description = $_POST['description'];
$id = $_POST['id'];

if(!isset($email) || !isset($nom) || !isset($prenom) || !isset($groups) || !isset($description) || !isset($id)) {
    $_SESSION['error'] = "Erreur lors de la modification de l'utilisateur, un champ n'a pas été rempli". $email . $nom . $prenom . $groups . $description . $id;
    header('Location: ../g_user.php');
    exit();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Erreur lors de la modification de l'utilisateur, l'email n'est pas valide";
    header('Location: ../g_user.php');
    exit();
}

if(!preg_match("/^[a-zA-Z-' ]*$/", $nom)) {
    $_SESSION['error'] = "Erreur lors de la modification de l'utilisateur, le nom n'est pas valide";
    header('Location: ../g_user.php');
    exit();
}

if(!preg_match("/^[a-zA-Z-' ]*$/", $prenom)) {
    $_SESSION['error'] = "Erreur lors de la modification de l'utilisateur, le prénom n'est pas valide";
    header('Location: ../g_user.php');
    exit();
}

if(!preg_match("/^[a-zA-Z-' ]*$/", $groups)) {
    $_SESSION['error'] = "Erreur lors de la modification de l'utilisateur, le groupe n'est pas valide";
    header('Location: ../g_user.php');
    exit();
}

require_once '../../assets/php/lib.php';

$dbh = connect();

$sql = 'SELECT * FROM profil WHERE id = ?';
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($result->num_rows === 0) {
    $_SESSION['error'] = "Erreur lors de la modification de l'utilisateur, cet utilisateur n'existe pas";
    header('Location: ../g_user.php');
    exit();
}

if($user['email'] !== $email) {
    $sql = 'SELECT * FROM profil WHERE email = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($result->num_rows !== 0) {
        $_SESSION['error'] = "Erreur lors de la modification de l'utilisateur, cet email est déjà utilisé";
        header('Location: ../g_user.php');
        exit();
    }
}


$nom = mysqli_real_escape_string($dbh, $nom);
$prenom = mysqli_real_escape_string($dbh, $prenom);
$email = mysqli_real_escape_string($dbh, $email);
$description = mysqli_real_escape_string($dbh, $description);


if($nom != $user['nom'] || $prenom != $user['prenom'] || $description != $user['description'] || $email != $user['email'] || $groups != $user['groups']) {
    $sql = 'UPDATE profil SET nom = ?, prenom = ?, email = ?, description = ?, `groups` = ? WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("sssssi", $nom, $prenom, $email, $description, $groups, $id);
    $stmt->execute();

    $_SESSION['error'] = "L'utilisateur a bien été modifié";
    header('Location: ../g_user.php');
    exit();


} else {
    $_SESSION['error'] = "Aucune modification effectuée";
    header('Location: ../g_user.php');
    exit();

}