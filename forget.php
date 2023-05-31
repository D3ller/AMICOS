<?php

session_start();

require_once('./assets/php/lib.php');

//dont display errors

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);


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
    $message = "
    http://localhost/forget.php?token=$token";

    if(mail($to, $subject, $message)){
        echo "Un mail vous a été envoyé";

    } else {
        echo "Une erreur est survenue";
        echo $message;
    }
}
}

}