<?php

session_start();
$session_lifetime = 86400;
ini_set('session.gc_maxlifetime', $session_lifetime);

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){
    header('Location: /index.php');
    exit;
}

require_once('./lib.php');

$email = $_POST['email'];
$password = $_POST['password'];

if(empty($email) || empty($password)){
    $_SESSION['error'] = "Veuillez remplir tous les champs";
    header('Location: /connexion.php');
    exit;
}

$dbh = connect();

$sql = "SELECT * FROM profil WHERE email = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    $_SESSION['error'] = "L'email n'existe pas";
    header('Location: /connexion.php');
    exit;
}

$user = $result->fetch_assoc();

if(!password_verify($password, $user['password'])){
    $_SESSION['error'] = "Le mot de passe est incorrect";
    header('Location: /connexion.php');
    exit;
}

$_SESSION['AMIMAIL'] = $email;
$_SESSION['AMIID'] = $user['id'];

header('Location: /index.php');

?>

