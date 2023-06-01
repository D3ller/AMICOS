<?php

session_start();

require_once('./assets/php/lib.php');

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMINAME'])) {

    $dbh = connect();

    $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    echo '<h1>Profil</h1>';
    echo $user["prenom"]. ' ' .$user["nom"].'<br>';
    echo $user["email"].'<br>';
    echo $user["description"].'<br>';

    echo '<a href="./assets/php/deconnexion.php">Déconnexion</a>';

    $sql = "SELECT * FROM trajet WHERE conducteur_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("s", $user['id']);

    $result = $stmt->execute();

    while($trajet = $result->fetch_assoc()) {
        $trajet['date'] = date('d/m/Y', strtotime($trajet['date']));
    
    
        echo '<h2>Trajets</h2>';
    
        echo '<div>';
        echo '<h3>Conducteur: Vous</h3>';
        echo '<p>'.$trajet['lieu_depart'].'</p>';
        echo '<p>'.$trajet['lieu_arrivee'].'</p>';
        echo '<p>'.$trajet['date'].'</p>';
        echo '<p>'.$trajet['duree'].'</p> | <p>'.$trajet['distance'].'</p> | <p>'.$trajet['co2'].'</p>';
        echo '</div>';
    }
    

} else {
    $_SESSION['error'] = "Vous n'êtes pas connecté";
    header('Location: ./connexion.php');
    exit();
}

?>