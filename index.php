<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    require_once 'header.php';
    ?>

<?php

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMINAME'])){
    echo "<p>Vous êtes connecté</p>";
    echo "<p>Bienvenue ".$_SESSION['AMINAME']."</p>";
    echo "<a href='./assets/php/deconnexion.php'>Déconnexion</a>";
} else {
    echo "<p>Vous n'êtes pas connecté</p>";
    echo "<a href='./connexion.php'>Connexion</a>";
    echo ' | ';
    echo "<a href='./inscription.php'>Inscription</a>";
}
?>
    
    <?php
    require_once 'footer.php';
    ?>
    
</body>
</html>