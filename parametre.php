<?php

session_start();

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])) {

} else {
    $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page";
    header('Location: /connexion.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type='text/css' rel='stylesheet' href='/assets/css/parametre.css'>
    <link type='text/css' rel='stylesheet' href='/assets/css/header-footer.css'>
    <title>Document</title>
</head>
<body>

<?php

require_once('customnav.php');

?>


<div id='settings'>

<div>
    <p>Avis</p><div class='arrow'></div>
    </div>

    <div>
    <p>Mot de passe</p><div class='arrow'></div>
    </div>

    <div>
    <p>Condition générales</p><div class='arrow'></div>
    </div>

    <div>
    <p>Cookies</p><div class='arrow'></div>
    </div>

</div>
    
</body>
</html>