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

    echo '<h2>Vos trajets</h2>';


    $sql = "SELECT * FROM trajet WHERE conducteur_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("s", $user['id']);
    $stmt->execute();

    $result = $stmt->get_result();

    while($trajet = $result->fetch_assoc()) {
        $trajet['date'] = new DateTime($trajet['date']);
        $trajet['date'] = $trajet['date']->format('d/m/Y H:i');

        $minutes = $trajet['duree'] * 60;
        $hours = floor($minutes / 60);
        $minutes = $minutes - ($hours * 60);
        $minutes = round($minutes / 60 * 60);

        $trajet['duree'] = $hours.'h'.$minutes;

        $sql2 = "SELECT * FROM profil WHERE id = ?";
        $stmt2 = $dbh->prepare($sql2);
        $stmt2->bind_param("s", $trajet['conducteur_id']);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $conducteur = $result2->fetch_assoc();

        
        echo '<div>';
        

        echo '<h3>Conducteur:'. $conducteur["prenom"].' '.$conducteur["nom"].'</h3>';
        echo '<p> Lieu départ:'.$trajet['lieu_depart'].'</p>';
        echo '<p> Lieu arrivé:'.$trajet['lieu_arrivee'].'</p>';
        echo '<p> Date:'.$trajet['date'].'</p>';
        echo '<p>Durée: '.$trajet['duree'].' | KM: '.$trajet['km'].'km | CO2: '.$trajet['co2'].'kg</p>';
        echo '<p> Nombre de place: '.$trajet['place'].' passager(s)</p>';
        echo '</div>';

        echo '<div>'
        echo '<h3>Passager(s)</h3>';
        $sql3 = "SELECT * FROM passager WHERE trajet_id = ?";
        $stmt3 = $dbh->prepare($sql3);
        $stmt3->bind_param("s", $trajet['id']);
        $stmt3->execute();
        $result3 = $stmt3->get_result();

        while($passager = $result3->fetch_assoc()) {
            $sql4 = "SELECT * FROM profil WHERE id = ?";
            $stmt4 = $dbh->prepare($sql4);
            $stmt4->bind_param("s", $passager['passager_id']);
            $stmt4->execute();
            $result4 = $stmt4->get_result();
            $passager = $result4->fetch_assoc();

            echo '<p>'.$passager['prenom'].' '.$passager['nom'].'</p>';
        }
        echo '</div>';
    }
    

} else {
    $_SESSION['error'] = "Vous n'êtes pas connecté";
    header('Location: ./connexion.php');
    exit();
}

?>