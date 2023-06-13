<?php

session_start();

require_once './lib.php';

$email = $_POST['email'];
$password = $_POST['password'];
$token = $_POST['token'];

if(!isset($email) || !isset($password) || !isset($token)) {
    $_SESSION['error'] = "Veuillez remplir tous les champs";
    header('Location: /forget.php');
    exit();

}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Adresse email invalide";
    header('Location: /forget.php?token='.$token);
    exit();

}

if(strlen($password) < 8 || strlen($password) > 50) {
    $_SESSION['error'] = "Mot de passe invalide";
    header('Location: /forget.php?token='.$token);
    exit();

}

if(!preg_match("#[0-9]+#", $password)) {
    $_SESSION['error'] = "Le mot de passe doit contenir au moins un chiffre";
    header('Location: /forget.php?token='.$token);
    exit();

}

if(!preg_match("#[a-z]+#", $password)) {
    $_SESSION['error'] = "Le mot de passe doit contenir au moins une minuscule";
    header('Location: /forget.php?token='.$token);
    exit();
}

if(!preg_match("#[A-Z]+#", $password)) {
    $_SESSION['error'] = "Le mot de passe doit contenir au moins une majuscule";
    header('Location: /forget.php?token='.$token);
    exit();
}

if(!preg_match("#\W+#", $password)) {
    $_SESSION['error'] = "Le mot de passe doit contenir au moins un caractère spécial";
    header('Location: /forget.php?token='.$token);
    exit();
}

$dbh = connect();

$sql = "SELECT * FROM profil WHERE email = ? AND token = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ss", $email, $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($result->num_rows == 0) {
    $_SESSION['error'] = "Ce profil n'existe pas";
    header('Location: /forget.php?token='.$token);
    exit();

}

$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE profil SET password = ?, token = NULL WHERE email = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ss", $hash, $email);
$stmt->execute();

$_SESSION['error'] = "Mot de passe modifié avec succès";
header('Location: /connexion.php');
exit();




?>