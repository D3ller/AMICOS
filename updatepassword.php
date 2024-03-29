<?php

session_start();

if(!isset($_SESSION['AMIMAIL']) || !isset($_SESSION['AMIID'])){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Vous n\'êtes pas connecté
    </p>
    </div>';
    header('Location: ./index.php');
    exit();
}

require_once './assets/php/lib.php';

$dbh = connect();

$sql = 'SELECT * FROM profil WHERE id = ? AND email = ?';
$stmt = $dbh->prepare($sql);
$stmt->bind_param("is", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($result->num_rows === 0) {
    header('Location: ../assets/php/deconnexion.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="/assets/css/conexion.css">
    <link type="text/css" rel="stylesheet" href="/assets/css/header-footer.css">
    <title>Modifier mot de passe</title>
</head>
<body>

<?php

if(isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}

require_once 'header.php';
require_once('customnav.php');
?>

<main id="mainupdtpass">

<h1>Modifier le mot de passe</h1>
<p>Il doit comporter au moins 8 caractères dont 1 lettre majuscule, 1 chiffre et 1 caractère spécial.</p>

<form id="formmodifpass" action="./assets/php/updatepassword.php" method="post">
    
<input name='oldpassword' type='password' id='oldpassword' placeholder='Mot de passe actuel'>
<input name='password' type='password' id='newpassword' placeholder='Nouveau mot de passe'>
<input name='confirmpassword' type='password' id='newpassword2' placeholder='Confirmer le nouveau mot de passe'>

<input id="subnewpass" type="submit" value="Modifier">
</form>

</main>

<?php
require_once('menu.php');
require_once('footer.php');
?>
    
</body>
</html>

