<?php 

session_start();

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
}

if($password != $password2){
    $_SESSION['error'] = "Les mots de passe ne sont pas identiques";
    header('Location: /inscription.php');
}

if(strlen($password) < 8){
    $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères";
    header('Location: /inscription.php');
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION['error'] = "L'email n'est pas valide";
    header('Location: /inscription.php');
}

if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}$/', $password)){
    $_SESSION['error'] = "Le mot de passe doit contenir au moins une lettre majuscule et un chiffre et un caractere special";
    header('Location: /inscription.php');
}

if($groupe != 'A' && $groupe != 'B' && $groupe != 'C' && $groupe != 'D' && $groupe != 'E' && $groupe != 'F'){
    $_SESSION['error'] = "Le groupe n'est pas valide";
    header('Location: /inscription.php');
}

//hash password

$password = password_hash($password, PASSWORD_DEFAULT);



$dbh = connect();

$sql = "SELECT * FROM profil WHERE email = :email";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":email", $email, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(count($result) > 0){
    $_SESSION['error'] = "L'email existe déjà";
    header('Location: /inscription.php');
    exit;
}

$description = "Je m'apelle $prenom $nom et je suis dans le groupe $groupe";
echo $password . "<br>" . $groupe . "<br>" . $description;

$sql = "INSERT INTO profil (email, password, nom, prenom, description, groups) VALUES (:email, :password, :nom, :prenom, :description, :groupe)";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":email", $email, PDO::PARAM_STR);
$stmt->bindParam(":password", $password, PDO::PARAM_STR);
$stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
$stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);
$stmt->bindParam(":description", $description, PDO::PARAM_STR);
$stmt->bindParam(":groupe", $groupe, PDO::PARAM_STR);

if ($stmt->execute()) {
    $_SESSION['error'] = "Inscription réussie";
    header('Location: /connexion.php');
} else {
    $_SESSION['error'] = "Erreur lors de l'inscription";
    header('Location: /inscription.php');
}

$dbh = null;

