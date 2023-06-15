<?php
session_start();

$email = $_POST['email'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$messages = $_POST['message'];
$sujet = $_POST['sujet'];


if(!preg_match("/^[a-zA-Z-' ]*$/", $nom)){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Le nom n\'est pas valide
    </p>
    </div>';
    header('Location: ../../contacts.php');
    exit();
}

if(!preg_match("/^[a-zA-Z-' ]*$/", $prenom)){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Le prénom n\'est pas valide
    </p>
    </div>';
    header('Location: ../../contacts.php');
    exit();
}

if(!preg_match("/^[a-zA-Z-' ]*$/", $sujet)){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Le sujet n\'est pas valide
    </p>
    </div>';
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
    $message .= '<p>'.$messages.'</p>';
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

    $from = 'noreply@amicos.fr';
    $fromName = 'SAE202';

    $message = '<html><body>';
    $message .= '<h1>'.$prenom. ' ' . $nom. ' nous a envoyé un message</h1>';
    $message .= '<h2>A propos de : '.$sujet.'</h2>';
    $message .= '<p>Voici le message que '.$prenom.' '.$nom.' nous a envoyé :</p>';
    $message .= '<p>'.$messages.'</p>';
    $message .= '</body></html>';

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "Organization: 2480\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
    $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n";

    $send2 = mail($to, $subject, $message, $headers);



if($send){
    $_SESSION['error'] = "Votre message a bien été envoyé";
    header('Location: ../../contacts.php');
    exit();
} else {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Une erreur est survenue lors de l\'envoi du message
    </p>
    </div>';
    header('Location: ../../contacts.php');
    exit();
}





} else {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>L\'adresse email n\'est pas valide
    </p>
    </div>';
    header('Location: ../../contacts.php');
    exit();
}