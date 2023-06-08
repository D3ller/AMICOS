<?php
session_start();

require_once './lib.php';

$id = $_POST['id'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$description = $_POST['description'];
$pp = $_POST['pp'];
$image = $_FILES['image'];

$dbh = connect();

$sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ss", $id, $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$old = $user['profil-picture'];



if(!isset($_POST['id']) || !isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['email']) || !isset($_POST['description'])) {
    $_SESSION['error'] = "Veuillez remplir tous les champs";
    header('Location: /profil.php');
    exit();
}

if($_POST['id'] != $_SESSION['AMIID'] || $_POST['email'] != $_SESSION['AMIMAIL']) {
    $_SESSION['error'] = "Vous n'avez pas le droit de modifier ce profil";
    header('Location: /profil.php');
    exit();

}

if($result->num_rows == 0) {
    $_SESSION['error'] = "Ce profil n'existe pas";
    header('Location: /profil.php');
    exit();

}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Adresse email invalide";
    header('Location: /profil.php');
    exit();

}

if(strlen($nom) < 2 || strlen($nom) > 50) {
    $_SESSION['error'] = "Nom invalide";
    header('Location: /profil.php');
    exit();

}

if(strlen($prenom) < 2 || strlen($prenom) > 50) {
    $_SESSION['error'] = "Prénom invalide";
    header('Location: /profil.php');
    exit();

}

if(strlen($description) < 2 || strlen($description) > 500) {
    $_SESSION['error'] = "Description invalide";
    header('Location: /profil.php');
    exit();

}

$sql = "SELECT * FROM profil WHERE email = ? AND id != ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("si", $email, $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    $_SESSION['error'] = "Cette adresse email est déjà utilisée";
    header('Location: /profil.php');
    exit();

}


$nom = mysqli_real_escape_string($dbh, $nom);
$prenom = mysqli_real_escape_string($dbh, $prenom);
$email = mysqli_real_escape_string($dbh, $email);


if($image['size'] == 0) {


if($nom != $user['nom'] || $prenom != $user['prenom'] || $description != $user['description'] || $email != $user['email']) {
    $sql = "UPDATE profil SET nom = ?, prenom = ?, description = ?, email = ? WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("ssssi", $nom, $prenom, $description, $email, $id);
    $stmt->execute();

    $_SESSION['AMIID'] = $id;
    $_SESSION['AMIMAIL'] = $email;
    $_SESSION['success'] = "Profil modifié avec succès";
    header('Location: /profil.php');
    exit();
} else {
    $_SESSION['error'] = "Aucune modification effectuée";
    header('Location: /profil.php');
    exit();


}


} else {

if($image['size'] > 2000000) {
    $_SESSION['error'] = "Image trop volumineuse";
    header('Location: /profil.php');
    exit();
}

if(!getimagesize($image['tmp_name'])) {
    $_SESSION['error'] = "Fichier invalide";
    header('Location: /profil.php');
    exit();
}

$ext = pathinfo($image['name'], PATHINFO_EXTENSION);

$ext = strtolower($ext);

$allowed = ['jpg', 'jpeg', 'png', 'gif'];

if(!in_array($ext, $allowed)) {
    $_SESSION['error'] = "Extension non autorisée";
    header('Location: /profil.php');
    exit();
}

$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
$filename = uniqid('', true) . '.' . $ext;
$destination = '../img/pp/' . $filename;

if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
    $pp = $filename;
    $pp = 'https://mmi22c01.sae202.ovh/assets/img/pp/' . $filename;
    
    $sql = "UPDATE profil SET nom = ?, prenom = ?, description = ?, email = ?, `profil-picture` = ? WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("sssssi", $nom, $prenom, $description, $email, $pp, $id);
    $stmt->execute();

    $_SESSION['AMIID'] = $id;
    $_SESSION['AMIMAIL'] = $email;
    $_SESSION['success'] = "Profil modifié avec succès";
    header('Location: /profil.php');
    exit();
} else {
    $_SESSION['error'] = "Erreur lors de l'upload de l'image";
    header('Location: /profil.php');
    exit();
}






}






