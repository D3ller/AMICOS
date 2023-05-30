<?php

session_start();

require_once('./lib.php');

$email = $_POST['email'];
$password = $_POST['password'];

if(empty($email) || empty($password)){
    $_SESSION['error'] = "Veuillez remplir tous les champs";
    header('Location: /connexion.php');
}

$dbh = connect();

$sql = "SELECT * FROM profil WHERE email = '$email'";
$result = $dbh->query($sql);

if($result->num_rows == 0){
    $_SESSION['error'] = "L'email n'existe pas";
    header('Location: /connexion.php');
}

$user = $result->fetch_assoc();

if(!password_verify($password, $user['password'])){
    $_SESSION['error'] = "Le mot de passe est incorrect";
    header('Location: /connexion.php');
}

$emailhash = password_hash($email, PASSWORD_DEFAULT);
$username = $user["nom"];

setcookie('AMIMAIL', $emailhash, time() + 3600, '/');
setcookie('AMINAME', $username, time() + 3600, '/');

header('Location: /index.php');


