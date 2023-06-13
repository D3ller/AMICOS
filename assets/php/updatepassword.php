<?php

session_start();

if(!isset($_SESSION['AMIMAIL']) || !isset($_SESSION['AMIID'])){
    $_SESSION['error'] = "Vous n'êtes pas connecté";
    header('Location: ./index.php');
    exit();
}

require_once('./lib.php');

$oldpassword = $_POST['oldpassword'];
$password = $_POST['password'];
$confirmpassword = $_POST['confirmpassword'];

$dbh = connect();

$sql = 'SELECT * FROM profil WHERE id = ? AND email = ?';
$stmt = $dbh->prepare($sql);
$stmt->bind_param("is", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($result->num_rows === 0) {
    header('Location: ../assets/php/deconnexion.php');
    exit();
}

if(!password_verify($oldpassword, $user['password'])) {
    $_SESSION['error'] = "Ancien mot de passe incorrect";
    header('Location: ../../updatepassword.php');
    exit();
}

if($password !== $confirmpassword) {
    $_SESSION['error'] = "Les mots de passe ne correspondent pas";
    header('Location: ../../updatepassword.php');
    exit();
}

if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}$/', $password)) {
    $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial";
    header('Location: ../../updatepassword.php');
    exit();
}

$sql = 'UPDATE profil SET password = ? WHERE id = ?';
$stmt = $dbh->prepare($sql);
$stmt->bind_param("si", password_hash($password, PASSWORD_DEFAULT), $_SESSION['AMIID']);
$stmt->execute();

header('Location: /updatepassword.php');    
