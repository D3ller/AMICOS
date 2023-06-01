<?php

session_start();

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMINAME'])){
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
    <link rel="stylesheet" href="./assets/css/connexion.css">
    <link rel="stylesheet" href="./assets/css/header-footer.css">
    <script src="./assets/js/script.js" DEEFER></script>
    <title>Connexion</title>
</head>
<body>
    <?php 
        require_once 'header.php';
    ?>

    <main>

        <?php

        if(isset($_SESSION['error'])){
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }

        ?>

            <form METHOD="POST" action="./assets/php/vconnexion.php">
                <input type="mail" id='mail' name="email" placeholder="email">
                <input type="password" name="password" placeholder="password">
                <input type="submit" name="submit" value="connexion">
            </form>

        <script>alert("Garde l'id de mot de pass oublié j'ai mis du js")</script>

            <a href="./inscription.php">Inscription</a> | <a id='forget' href="./forget.php">Mot de passe oublié</a>

    </main>

        <script>
    var forget = document.getElementById('forget');
    var mail = document.getElementById('mail');

    mail.addEventListener('input', function(){
        forget.href = './forget.php?mail='+mail.value;
    })
    </script>

    <?php 
    require_once 'footer.php';
    ?>

</body>
</html>