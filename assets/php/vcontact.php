<?php
session_start();

$email = $_POST['email'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$message = $_POST['message'];
$sujet = $_POST['sujet'];


if(!preg_match("/^[a-zA-Z-' ]*$/", $nom)){
    $_SESSION['error'] = "Le nom n'est pas valide";
    header('Location: ../../contacts.php');
    exit();
}

if(!preg_match("/^[a-zA-Z-' ]*$/", $prenom)){
    $_SESSION['error'] = "Le prénom n'est pas valide";
    header('Location: ../../contacts.php');
    exit();
}

if(!preg_match("/^[a-zA-Z-' ]*$/", $sujet)){
    $_SESSION['error'] = "Le sujet n'est pas valide";
    header('Location: ../../contacts.php');
    exit();
}


if(filter_var($email, FILTER_VALIDATE_EMAIL)){

    $to = $email;
    $subject = "Votre message a bien été envoyé";

    $from = 'sae202@amicos.fr';
    $fromName = 'SAE202';

    $message = '<html><body>';
    $message .= '<h1>'.$prenom. ' ' . $nom. ' nous avons bien reçu votre message</h1>';
    $message .= '<h2>A propos de : '.$sujet.'</h2>';
    $message .= '<p>Voici le message que vous nous avez envoyé :</p>';
    $message .= '<p>'.$message.'</p>';
    $message .= '</body></html>';

    $headers = "MIME-Version: 1.0" . "\r\n"; 
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
    $headers .= "Organization: 2480\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
    $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n";
    $headers .= 'Reply-to: no-reply@mmi-troyes.fr';


$send = mail($to, $subject, $message, $headers);

    $to = "corentinnelhomme@karibsen.fr";
    $subject = "Nouveau message de ".$prenom." ".$nom;

    $from = 'sae202@amicos.fr';
    $fromName = 'SAE202';

    $message = '<html><body>';
    $message .= '<h1>'.$prenom. ' ' . $nom. ' nous a envoyé un message</h1>';
    $message .= '<h2>A propos de : '.$sujet.'</h2>';
    $message .= '<p>Voici le message que '.$prenom.' '.$nom.' nous a envoyé :</p>';
    $message .= '<p>'.$message.'</p>';
    $message .= '</body></html>';

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "Organization: 2480\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
    $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n";


if($send){
    $_SESSION['error'] = "Votre message a bien été envoyé";
    header('Location: ../../contacts.php');
    exit();
} else {
    $_SESSION['error'] = "Une erreur est survenue";
    header('Location: ../../contacts.php');
    exit();
}





} else {
    $_SESSION['error'] = "L'email n'est pas valide";
    header('Location: ../../contacts.php');
    exit();
}