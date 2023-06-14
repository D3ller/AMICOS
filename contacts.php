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
    <link rel="stylesheet" href="/assets/css/contacts.css">
    <link rel="stylesheet" href="/assets/css/header-footer.css">
    <script src="./assets/js/script.js" DEEFER></script>
    <title>Contacts</title>
</head>
<body>

<?php
require_once 'header.php';
require_once('customnav.php');
?>

<main>
    <?php
    if(isset($_SESSION['error'])){
        echo '<p class="error">'.$_SESSION['error'].'</p>';
        unset($_SESSION['error']);
    }

    ?>

    <form id='contact' method='POST' action='./assets/php/vcontact.php'>

    <?php

    if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){

        $dbh = connect();

        $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        echo '<div>';
        echo '<label for="nom">Nom</label>';
        echo '<input type="text" name="nom" value="'.$user['nom'].'" placeholder="Nom" required>';
        echo '</div>';

        echo '<div>';
        echo '<label for="prenom">Prénom</label>';
        echo '<input type="text" name="prenom" value="'.$user['prenom'].'" placeholder="Prénom" required>';
        echo '</div>';

        echo '<div>';
        echo '<label for="email">Email</label>';
        echo '<input type="text" name="email" value="'.$user['email'].'" placeholder="Email" required>';
        echo '</div>';
    } else {
        echo '<div>';
        echo '<label for="nom">Nom</label>';
        echo '<input type="text" name="nom" placeholder="Nom" required>';
        echo '</div>';

        echo '<div>';
        echo '<label for="prenom">Prénom</label>';
        echo '<input type="text" name="prenom" placeholder="Prénom" required>';
        echo '</div>';

        echo '<div>';
        echo '<label for="email">Email</label>';
        echo '<input type="text" name="email" placeholder="Email" required>';
        echo '</div>';
    }

    ?>
    <div>
    <label for="sujet">Sujet</label>
    <input type="text" name="sujet" placeholder="Sujet" required>
    </div>
    
    <div>
    <label for="message">Message</label>
    <textarea name="message" placeholder="Message" required></textarea>
    </div>

    <div>
        <div>
    <input type="submit" value="Envoyer">
    <div>
    </div>


    </form>
</main>
<?php
require_once 'footer.php';
?>

</body>
</html>