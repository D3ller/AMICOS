<?php 

session_start();

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){
    header('Location: /index.php');
    exit;
}

require_once('./lib.php');

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$groupe = $_POST['group'];

if(empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($password2) || empty($groupe)) {
$_SESSION['error'] = "Veuillez remplir tous les champs";
header('Location: /inscription.php');
exit();
}

if($password != $password2){
    $_SESSION['error'] = "Les mots de passe ne sont pas identiques";
    header('Location: /inscription.php');
    exit();
}

if(strlen($password) < 8){
    $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères";
    header('Location: /inscription.php');
    exit();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION['error'] = "L'email n'est pas valide";
    header('Location: /inscription.php');
    exit();
}

if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}$/', $password)){
    $_SESSION['error'] = "Le mot de passe doit contenir au moins une lettre majuscule et un chiffre et un caractere special";
    header('Location: /inscription.php');
    exit();
}

if($groupe != 'A' && $groupe != 'B' && $groupe != 'C' && $groupe != 'D' && $groupe != 'E' && $groupe != 'F'){
    $_SESSION['error'] = "Le groupe n'est pas valide";
    header('Location: /inscription.php');
    exit();

}

$password = password_hash($password, PASSWORD_DEFAULT);



$dbh = connect();

$sql = "SELECT * FROM profil WHERE email = '$email'";
$result = $dbh->query($sql);

if($result->num_rows > 0){
    $_SESSION['error'] = "L'email existe déjà";
    header('Location: /inscription.php');
    exit();
}

$description = "Je m\'appelle $prenom $nom et je suis dans le groupe $groupe";

$password = mysqli_real_escape_string($dbh, $password);

$sql = "INSERT INTO profil (email, password, nom, prenom, description, `groups`) VALUES ('$email', '$password', '$nom', '$prenom', '$description', '$groupe')";

if ($dbh->query($sql) === TRUE) {
    // echo "Votre inscription à réussie! Veuillez activez votre compte avec le lien envoyé par mail ou en scannant le QR code ci-dessous";
    $sql = "SELECT * FROM profil WHERE email = '$email'";
    $result = $dbh->query($sql);
    $user = $result->fetch_assoc();
    $id = $user['id'];
    $_SESSION['error'] = "Votre inscription à réussie!";
    header('Location: /connexion.php');

    // echo "<img src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://portfolio.karibsen.fr/active?id=".$id.".png' alt='QR Code' />";


} else {
    $_SESSION['error'] = "Erreur lors de l'inscription";
    echo $dbh->error;
}

$dbh->close();
