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

        <?php

        if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMINAME'])){
            // echo "<p>Vous êtes connecté</p>";

            $dbh = connect();

            $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
            $stmt = $dbh->prepare($sql);
            $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();    

            echo "<p class='header-p-white'>Bienvenue ".$user['prenom']." <a href='./assets/php/deconnexion.php'>Déconnexion</a></p>";
        } else {
            // echo "<p>Vous n'êtes pas connecté</p>";
            echo "<a class='info-con' href='./connexion.php'>Connexion</a>";
            echo ' | ';
            echo "<a class='info-con' href='./inscription.php'>Inscription</a>";
            echo ' | ';
            echo "<a class='info-con' href='./forget.php'>Mot de passe oublié</a>";
        }
        ?>

    </main>
    
    <?php
    require_once 'footer.php';
    ?>
    
</body>
</html>