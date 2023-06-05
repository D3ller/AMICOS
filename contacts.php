<?php

session_start();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/contacts.css">
    <link rel="stylesheet" href="./assets/css/header-footer.css">
    <script src="./assets/js/script.js" DEEFER></script>
    <title>Contacts</title>
</head>
<body>
    <h1>Contacts</h1>

    <?php
    require_once 'header.php';

    ?>

    <form method='POST' action=''>

    <?php

    if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){

        $dbh = connect();

        $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        echo '<input type="text" name="nom" value="'.$user['nom'].'" placeholder="Nom" required>';
        echo '<input type="text" name="prenom" value="'.$user['prenom'].'" placeholder="Prénom" required>';
        echo '<input type="text" name="email" value="'.$user['email'].'" placeholder="Email" required>';
    } else {
        echo '<input type="text" name="nom" placeholder="Nom" required>';
        echo '<input type="text" name="prenom" placeholder="Prénom" required>';
        echo '<input type="text" name="email" placeholder="Email" required>';
    }

    ?>
    
    <textarea name="message" placeholder="Message" required></textarea>

    <input type="submit" value="Envoyer">


    </form>
</body>
</html>