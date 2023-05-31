<?php
//tjr laissez le session start en haut de la page
session_start();

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMINAME'])){
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
    <link rel="stylesheet" href="./assets/css/contacts.css">
    <script src="./assets/js/script.js" DEEFER></script>
    <title>Inscription</title>
</head>
<body>

<?php
//verifie si y'a une erreur et si y'en a une affiche la mais tu peux deplacer cette partie n'importe ou dans le code
if(isset($_SESSION['error'])){
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}

?>

    <form method="POST" action="./assets/php/vinscription.php">
    <input type="text" name="nom" id="nom" placeholder="Nom">
    <input type="text" name="prenom" id="prenom" placeholder="Prénom">
    <input type="text" name="email" id="email" placeholder="Email">
    <input type="text" name="password" id="password" placeholder="Mot de passe">
    <input type="text" name="password2" id="password2" placeholder="Confirmer le mot de passe">
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
</body>
</html>