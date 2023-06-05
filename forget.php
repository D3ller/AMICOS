<?php

session_start();

require_once 'header.php';

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){
    $_SESSION['error'] = ['Vous êtes déjà connecté'];
    header('Location: /index.php');
    exit;
}

require_once('./assets/php/lib.php');

$email = $_GET['mail'];
$token = $_GET['token'];

if(!empty($token)) {

$dbh = connect();

$sql = "SELECT * FROM profil WHERE token = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($result->num_rows == 0){
echo "Le token n'existe pas";
} else {
echo '<form action="./assets/php/vforget.php" method="POST">';
echo '<input type="hidden" name="token" value="'.$token.'">';
echo '<input type="mail" name="email" value="'.$user['email'].'" disabled>';
echo '<input type="password" name="password" placeholder="password">';
echo '<input type="submit" name="submit" value="Changer">';
echo '</form>';
}

} else {

if(empty($email)){
echo "<input type='text' id='mail' placeholder='email'>";
echo "<a id='forget' href=''>Envoyer</a>";
echo "<script>mail.addEventListener('input', function(){
    forget.href = './forget.php?mail='+mail.value;
})
</script>";
} else {

//Lorsque l'utilisateur a mis son mail dans connexion et qu'il est transmis à forget.php, on vérifie si l'utilisateur existe dans la base de données
$dbh = connect();

$sql = "SELECT * FROM profil WHERE email = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($result->num_rows == 0){
    echo "<input type='text' id='mail' placeholder='email'>";
    echo "<a id='forget' href=''>Envoyer</a>";
    echo "<script>mail.addEventListener('input', function(){
        forget.href = './forget.php?mail='+mail.value;
    })
    </script>";
} else {

    if($user['token'] != NULL)   {
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
    $message = "http://mmi22c01.sae202.ovh/forget.php?token=$token";

    $from = 'mmi22c01@mmic01.mmi-troyes.fr';
    $fromName = 'Réinitialisation de mot de passe';

    $message = '<html><body>';
    $message .= '<h1>Changement de mot de passe</h1>';
    $message .= '<p>Vous avez demandé un changement de mot de passe, veuillez cliquer sur le lien suivant pour le changer</p>';
    $message .= '<a href="'.$message.'">Changer</a>';
    $message .= '</body></html>';

  
    $headers = "MIME-Version: 1.0" . "\r\n"; 
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
            $headers .= "Organization: 2480\r\n";
            $headers .= "X-Priority: 3\r\n";
            $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
            $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n";
            $headers .= 'Reply-to: no-reply@mmi-troyes.fr';
    

    $send = mail($to, $subject, $message, $headers);

    echo $send;

    if($send){
        echo "Un mail vous a été envoyé";
    } else {
        echo "Une erreur est survenue";
    }
}
}

}