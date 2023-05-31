<?php

session_start();

require_once('./assets/php/lib.php');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/header-footer.css">
    <script src="./assets/js/script.js" DEEFER></script>
    <title>Accueil</title>
</head>
<body>
    <?php 
    require_once 'header.php';
    ?>
    

    <main>

        

    </main>

    <input type="text" value="Départ" onclick="">
<input type="text" value="Arrivée" onclick="">
<input type="datetime-local" value="Date" onclick="">
<input type="submit" value="Rechercher">

    
    <?php
    require_once 'footer.php';
    ?>
    
</body>
</html>