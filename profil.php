<?php

session_start();

ini_set('display_errors', 0);

require_once('./assets/php/lib.php');

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])) {

} else {
    $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page";
    header('Location: /connexion.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link type="text/css" rel="stylesheet" href="/assets/css/profil.css">
    <link rel="stylesheet" href="./assets/css/header-footer.css">
</head>
<body>
    

<main>

<?php

require_once('customnav.php');

if(isset($_SESSION['error'])){
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}



    $dbh = connect();
    $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
echo '<div id="profil">';
    
    if($user["description"] == ""){
        $user["description"] = "Aucune description";
    }


    echo '<img id="profil-pic" src="'.$user["profil-picture"].'" alt="Photo de profil">';
    echo '<div id="edit-name"><h1>'.$user["prenom"]. ' ' .$user["nom"].'</h1><a href="./edit.php"><div id="edit"></div></a></div>';
    echo '<p class="grey">'.$user['sexe'] . ' '. $user['age']. ' ans</p>';
    echo '</div>';

    echo '<div id="preference">';

    // Vérifier si les préférences de l'utilisateur existent et définir l'état des cases à cocher en conséquence
    $preferences = $user['preferences'];
    $checked = "";
    
    echo '<div class="pref">';
    echo '<h2 class="subtitle">Préférences de covoiturage</h2>';
    echo '<div>';
    echo '<div class="subpref">';
    echo '<input type="checkbox" id="fumeur" name="fumeur" disabled';
    
    // Vérifier si la préférence "fumeur" est cochée
    if ($preferences !== NULL && in_array('fumeur', $preferences)) {
        $checked = "checked";
    }
    echo $checked;
    echo '>';
    echo '<label for="fumeur" class="greys cb">Fumeur</label>';
    echo '</div>';
    
    $checked = "";
    
    echo '<div class="subpref">';
    echo '<input type="checkbox" id="music" name="music" disabled';
    
    // Vérifier si la préférence "music" est cochée
    if ($preferences !== NULL && in_array('music', $preferences)) {
        $checked = "checked";
    }
    echo $checked;
    echo '>';
    echo '<label for="music" class="greys cb">Musique</label>';
    echo '</div>';
    
    $checked = "";
    
    echo '<div class="subpref">';
    echo '<input type="checkbox" id="animal" name="animal" disabled';
    
    // Vérifier si la préférence "animal" est cochée
    if ($preferences !== NULL && in_array('animal', $preferences)) {
        $checked = "checked";
    }
    echo $checked;
    echo '>';
    echo '<label for="animal" class="greys cb">Animaux</label>';
    echo '</div>';
    
    $checked = "";
    
    echo '<div class="subpref">';
    echo '<input type="checkbox" id="discussion" name="discussion" disabled';
    
    if ($preferences !== NULL && in_array('discussion', $preferences)) {
        $checked = "checked";
    }
    echo $checked;
    echo '>';
    echo '<label for="discussion" class="greys cb">Discussion</label>';
    echo '</div>';
    
    $checked = "";
    
    echo '<div class="subpref">';
    echo '<input type="checkbox" id="sharepayement" name="sharepayement" disabled';
    
    if ($preferences !== NULL && in_array('sharepayement', $preferences)) {
        $checked = "checked";
    }
    echo $checked;
    echo '>';
    echo '<label for="sharepayement" class="greys cb">Frais divisé</label>';
    echo '</div>';
    
    $checked = "";
    
    echo '<div class="subpref">';
    echo '<input type="checkbox" id="sharecar" name="sharecar" disabled';
    
    if ($preferences !== NULL && in_array('sharecar', $preferences)) {
        $checked = "checked";
    }
    echo $checked;
    echo '>';
    echo '<label for="sharecar" class="greys cb">2nd pilote</label>';
    echo '</div>';
    
    echo '</div>';
    echo '</div>';
    
    // Continuer avec le reste de votre code...
    


    echo '</div>';

    if($user['voiture'] == NULL) {
        $user['voiture'] = "Aucune voiture";
    } else {
        $user['voiture'] = $user['voiture'];
    }

    $text = str_replace("\r\n",'', $user["description"]);
    $text = str_ireplace(array("\r","\n",'\r','\n'),'<br>', $text);
    $text = str_replace(array("\r\n", "\r", "\n"), "<br>", $text);
    $text = stripslashes($text);

    echo '<div class="pref" style="margin: 0 20px; margin-bottom: 20px">';
    echo '<h2 class="subtitle">Voiture</h2>';
    echo '<p class="greys">'.$user["voiture"].'</p>';
    echo '</div>';

    echo '<div class="pref" style="margin: 0 20px; margin-bottom: 20px">';
    echo '<h2 class="subtitle">Description</h2>';
    echo '<p class="greys">'.$text.'</p>';
    echo '</div>';

    echo '</div>';

    echo '<div id="buttons">';

    echo '<div class="button">';
    echo '<a href="./statistique.php"><button><img src="https://portfolio.karibsen.fr/assets/img/stats.svg" alt="Statistiques"></button><p class="title">Statistiques</p></a>';
    echo '</div>';

    echo '<div class="button">';
    echo '<a href="./historique.php"><button><img src="https://portfolio.karibsen.fr/assets/img/clock.svg" alt="historique"></button><p class="title">Historique</p></a>';
    echo '</div>';

    echo '<div class="button">';
    echo '<a href="./assets/php/deconnexion.php"><button><img src="https://portfolio.karibsen.fr/assets/img/door.svg" alt="deconnexion"></button><p class="title">Déconnexion</p></a>';
    echo '</div>';

    echo '</div>';

    require_once('./footer.php');


?>


</main>

</body>
</html>