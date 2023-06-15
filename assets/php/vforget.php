<?php

session_start();

require_once './lib.php';

$email = $_POST['email'];
$password = $_POST['password'];
$token = $_POST['token'];

if(!isset($email) || !isset($password) || !isset($token)) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Aucun champ ne doit être vide
    </p>
    </div>';
    header('Location: /forget.php');
    exit();

}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Votre email n\'est pas valide
    </p>
    </div>';
    header('Location: /forget.php?token='.$token);
    exit();

}

if(strlen($password) < 8 || strlen($password) > 50) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Votre mot de passe doit contenir entre 8 et 50 caractères
    </p>
    </div>';
    header('Location: /forget.php?token='.$token);
    exit();

}

if(!preg_match("#[0-9]+#", $password)) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Votre mot de passe doit contenir au moins un chiffre
    </p>
    </div>';
    header('Location: /forget.php?token='.$token);
    exit();

}

if(!preg_match("#[a-z]+#", $password)) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Votre mot de passe doit contenir au moins une minuscule
    </p>
    </div>';
    header('Location: /forget.php?token='.$token);
    exit();
}

if(!preg_match("#[A-Z]+#", $password)) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Votre mot de passe doit contenir au moins une majuscule
    </p>
    </div>';
    header('Location: /forget.php?token='.$token);
    exit();
}

if(!preg_match("#\W+#", $password)) {
    $_SESSION['error'] = '
    <div class="errorred">
        <div class="errorunderred">
            <div class="errorredcaracter">
            </div>
        
        </div>
        <h1>Erreur !</h1>
        <p>Votre mot de passe doit contenir au moins un caractère spécial
        </p>
        </div>';
    header('Location: /forget.php?token='.$token);
    exit();
}

$dbh = connect();

$sql = "SELECT * FROM profil WHERE email = ? AND token = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ss", $email, $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($result->num_rows == 0) {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Le token est invalide
    </p>
    </div>';
    header('Location: /forget.php?token='.$token);
    exit();

}

$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE profil SET password = ?, token = NULL WHERE email = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ss", $hash, $email);
$stmt->execute();

$_SESSION['error'] = '<div class="errorred ">
<div class="errorunderred valided">
    <div class="errorredcaracter validedcaracter">
    </div>

</div>
<h1>Validé !</h1>
<p>Votre mot de passe a bien été modifié
</p>
</div>';
header('Location: /connexion.php');
exit();




?>