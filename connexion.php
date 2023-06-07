<?php

session_start();

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){
    $_SESSION['error'] = "<p>Vous êtes déjà connecté</p>";
    header('Location: /index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/conexion.css">
    <link rel="stylesheet" href="./assets/css/header-footer.css">
    <script src="./assets/js/script.js" DEFER></script>
    <title>Connexion</title>
</head>
<body>
    <main>
        <?php
        if(isset($_SESSION['error'])){
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
        ?>

        <div class="conn-logo">
            <div class="nom-perso-logo-2"></div>
        </div>




        <div class="form-inscription">
            <form METHOD="POST" action="./assets/php/vconnexion.php">
                <input class="email" type="email" id='mail' name="email" placeholder="email">
                <input class="lock" type="password" name="password" placeholder="password">
                <input class="center" type="submit" name="submit" value="connexion">
            </form>
            <a class="center inscription" href="./inscription.php">Inscription</a> 
            <a class="lost-password" id='forget' href="./forget.php">Mot de passe oublié</a>
        </div>

        <!-- <script>alert("Garde l'id de mot de pass oublié j'ai mis du js")</script> -->

    </main>

        <script>
    var forget = document.getElementById('forget');
    var mail = document.getElementById('mail');

    mail.addEventListener('input', function(){
        forget.href = './forget.php?mail='+mail.value;
    })
    </script>

</body>
</html>