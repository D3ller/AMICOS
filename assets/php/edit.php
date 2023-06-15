<?php
session_start();

require_once './lib.php';

$id = $_POST['id'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$description = $_POST['description'];
$pp = $_POST['pp'];
$voiture = $_POST['voiture'];
$image = $_FILES['image'];

$dbh = connect();

$sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ss", $id, $_SESSION['AMIMAIL']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$old = $user['profil-picture'];



if(!isset($_POST['id']) || !isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['email']) || !isset($_POST['description']) || !isset($_POST['voiture'])) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Veuillez remplir tous les champs</p>
    </div>';
    header('Location: /profil.php');
    exit();
}

if($_POST['id'] != $_SESSION['AMIID']) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Vous n\'avez pas le droit de modifier ce profil</p>
    </div>';
    header('Location: /profil.php');
    exit();

}

if($result->num_rows == 0) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Ce profil n\'existe ppas</p>
    </div>';
    header('Location: /profil.php');
    exit();

}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Adresse email invalide</p>
    </div>';
    header('Location: /profil.php');
    exit();

}

if(strlen($nom) < 2 || strlen($nom) > 50) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Votre nom est invalide</p>
    </div>';
    header('Location: /profil.php');
    exit();

}

if(strlen($prenom) < 2 || strlen($prenom) > 50) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Votre prénom est invalide</p>
    </div>';
    header('Location: /profil.php');
    exit();

}

if(strlen($description) < 2 || strlen($description) > 500) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Description invalide</p>
    </div>';
    header('Location: /profil.php');
    exit();

}

$sql = "SELECT * FROM profil WHERE email = ? AND id != ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("si", $email, $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Votre adresse mail est déja utilisé</p>
    </div>';
    header('Location: /profil.php');
    exit();

}


$nom = mysqli_real_escape_string($dbh, $nom);
$prenom = mysqli_real_escape_string($dbh, $prenom);
$email = mysqli_real_escape_string($dbh, $email);

if($image['size'] == 0) {

if($nom != $user['nom'] || $prenom != $user['prenom'] || $description != $user['description'] || $email != $user['email'] || $voiture != $user['voiture']) {
    $sql = "UPDATE profil SET nom = ?, prenom = ?, description = ?, email = ?, voiture = ? WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("sssssi", $nom, $prenom, $description, $email, $voiture, $id);
    $stmt->execute();

    $_SESSION['AMIID'] = $id;
    $_SESSION['AMIMAIL'] = $email;
    $_SESSION['success'] = '<div class="errorred ">
    <div class="errorunderred valided">
        <div class="errorredcaracter validedcaracter">
        </div>
    
    </div>
    <h1>Validé !</h1>
    <p>Votre profil a bien été modifié</p>
    </p>
    </div>';
    header('Location: /profil.php');
    exit();
} else {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Aucune modification n\'a été effectué</p>
    </div>';
    header('Location: /profil.php');
    exit();


}


} else {

if($image['size'] > 2000000) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>La taille de l\'image est trop grande</p>
    </div>';
    header('Location: /profil.php');
    exit();
}

if(!getimagesize($image['tmp_name'])) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Votre image est invalide </p>
    </div>';    header('Location: /profil.php');
    exit();
}

$ext = pathinfo($image['name'], PATHINFO_EXTENSION);

$ext = strtolower($ext);

$allowed = ['jpg', 'jpeg', 'png', 'gif'];

if(!in_array($ext, $allowed)) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>L\'extension de votre image n\'est pas prise en compte</p>
    </div>';
    header('Location: /profil.php');
    exit();
}

$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
$filename = uniqid('', true) . '.' . $ext;
$destination = '../img/pp/' . $filename;

if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
    $pp = $filename;
    $pp = 'https://mmi22c01.sae202.ovh/assets/img/pp/' . $filename;
    
    $sql = "UPDATE profil SET nom = ?, prenom = ?, description = ?, email = ?, `profil-picture` = ?, voiture = ? WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("ssssssi", $nom, $prenom, $description, $email, $pp, $voiture, $id);
    $stmt->execute();

    $_SESSION['AMIID'] = $id;
    $_SESSION['AMIMAIL'] = $email;
    $_SESSION['error'] = '<div class="errorred ">
    <div class="errorunderred valided">
        <div class="errorredcaracter validedcaracter">
        </div>
    
    </div>
    <h1>Validé !</h1>
    <p>Votre profil a été modifié avec succès
    </p>
    </div>';
    header('Location: /profil.php');
    exit();
} else {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Erreur lors de la publication de votre image</p>
    </div>';    header('Location: /profil.php');
    exit();
}






}






