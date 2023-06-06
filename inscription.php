<?php
//tjr laissez le session start en haut de la page
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
    <script src="./assets/js/script.js" DEEFER></script>
    <title>Inscription</title>
</head>
<body>

    <main>
    <?php
        //verifie si y'a une erreur et si y'en a une affiche la mais tu peux deplacer cette partie n'importe ou dans le code
        if(isset($_SESSION['error'])){
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }

        ?>

        <div class="conn-logo">
            
        </div>
        <div class="form-inscription">
            <form method="POST" action="./assets/php/vinscription.php">
                <input type="text" name="nom" id="nom" placeholder="Nom">
                <input type="text" name="prenom" id="prenom" placeholder="Prénom">
                <input type="text" name="email" id="email" placeholder="Email">
                <input type="password" name="password" id="password" placeholder="Mot de passe">
                <input type="password" name="password2" id="password2" placeholder="Confirmer le mot de passe">
                <select name="group" required>
                    <option value="">Groupe</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                    <option value="F">F</option>
                </select>

                <input type="submit" value="S'inscrire">
            </form>
        </div>
    </main>

    <?php 
        require_once 'menu.php';
        require_once 'footer.php';
    ?>
</body>
</html>