<?php

session_start();

require_once('./lib.php');

$email = $_POST['email'];
$password = $_POST['password'];

if(empty($email) || empty($password)){
    $_SESSION['error'] = "Veuillez remplir tous les champs";
    header('Location: /connexion.php');
    exit;
}

$dbh = connect();

$sql = "SELECT * FROM profil WHERE email = :email";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":email", $email, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(count($result) == 0){
    $_SESSION['error'] = "L'email n'existe pas";
    header('Location: /connexion.php');
    exit;
}

$user = $result[0];

if(!password_verify($password, $user['password'])){
    $_SESSION['error'] = "Le mot de passe est incorrect";
    header('Location: /connexion.php');
    exit;
}

$emailhash = password_hash($email, PASSWORD_DEFAULT);
$username = $user['prenom'];

setcookie('AMIMAIL', $emailhash, time() + 3600, '/');
setcookie('AMINAME', $username, time() + 3600, '/');

header('Location: /index.php');

?>

