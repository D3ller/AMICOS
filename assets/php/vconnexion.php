<?php

session_start();
$session_lifetime = 86400;
ini_set('session.gc_maxlifetime', $session_lifetime);

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Vous ne pouvez pas accéder à cette page en étant connecté
    </p>
    </div>';
    header('Location: /index.php');
    exit;
}

require_once('./lib.php');

$email = $_POST['email'];
$password = $_POST['password'];

if(empty($email) || empty($password)){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Veuillez remplir tous les champs
    </p>
    </div>';
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
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Votre email n\'est pas enregistré
    </p>
    </div>';
    header('Location: /connexion.php');
    exit;
}

$user = $result->fetch_assoc();

if(!password_verify($password, $user['password'])){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Votre mot de passe est incorrect
    </p>
    </div>';
    header('Location: /connexion.php');
    exit;
}

$_SESSION['AMIMAIL'] = $email;
$_SESSION['AMIID'] = $user['id'];

header('Location: /index.php');
$_SESSION["error"] = '<div class="errorred ">
<div class="errorunderred valided">
    <div class="errorredcaracter validedcaracter">
    </div>

</div>
<h1>Validé !</h1>
<p>Vous êtes connecté
</p>
</div>';
exit();


?>

