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

if(isset($_SESSION['error'])){
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}

?>

    <form METHOD="POST" action="./assets/php/vconnexion.php">
        <input type="mail" name="email" placeholder="email">
        <input type="password" name="password" placeholder="password">
        <input type="submit" name="submit" value="connexion">
    </form>
</body>
</html>