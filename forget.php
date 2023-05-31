<?php

session_start();

require_once('./assets/php/lib.php');

$email = $_GET['mail'];

if(empty($email)){
echo "<input type='text' id='mail' placeholder='email'>";
} else {
$dbh = connect();

$sql = "SELECT * FROM profil WHERE email = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($result->num_rows == 0){
echo "<input type='text' id='mail' placeholder='email'>";
} else {


    if($user['token'] = ' ' || $user['token'] = '' || $user['token'] != null){
        echo "Vous avez déjà demandé un changement de mot de passe, veuillez vérifier vos mails<br><br>";
        exit;
    } else {

    }

    $token = bin2hex(random_bytes(32));
    $sql = "UPDATE profil SET token = ? WHERE email = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();

    $to = $email;
    $subject = "Changement de mot de passe";
    $message = "
    http://localhost/forget.php?token=$token";

    if(mail($to, $subject, $message)){
        echo "Un mail vous a été envoyé";
    } else {
        echo "Une erreur est survenue";
    }


}
}