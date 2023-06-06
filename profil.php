<?php

session_start();

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

if(isset($_SESSION['error'])){
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}



require_once 'header.php';

    $dbh = connect();
    //Je récupère les infos de l'utilisateur
    $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    echo '<h1>Profil</h1>';

    echo '<img id="profil-pic" src="'.$user["profil-picture"].'" alt="Photo de profil">';
    echo '<h1>'.$user["prenom"]. ' ' .$user["nom"].'</h1>';
    echo '<h4>'.$user["email"].'</h4>';
    echo $user["description"].'<br>';

    echo '<a href="./assets/php/deconnexion.php">Déconnexion</a>';
    echo "  ";
    echo '<a href="./edit.php">Modifier le profil</a>';

    $sql5 = "SELECT * FROM passager INNER JOIN trajet ON trajet.id = passager.trajet_id WHERE passager.user_id = ? AND trajet.date > NOW() ORDER BY trajet.date ASC";
    $stmt5 = $dbh->prepare($sql5);
    $stmt5->bind_param("s", $user['id']);
    $stmt5->execute();
    
    $result5 = $stmt5->get_result();
    $num_rows5 = $result5->num_rows;


    $sql = "SELECT * FROM trajet WHERE conducteur_id = ? AND date > NOW()";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("s", $user['id']);
    $stmt->execute();

    $result = $stmt->get_result();
    $number = $result->num_rows;
    $number = $number + $num_rows5;

    //Je récupère les trajets en cours de l'utilisateur



    echo '<h2>Vos trajets en cours ('. $number. ')</h2>';

    echo '<div id="card-lister">';


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

        $sql3 = "SELECT * FROM passager WHERE trajet_id = ? AND user_id != ?";
        $stmt3 = $dbh->prepare($sql3);
        $stmt3->bind_param("ss", $trajet['id'], $user['id']);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $num_rows = $result3->num_rows;


        echo '<p> Nombre de place:'. $num_rows. '/'.$trajet['place'].' passager(s)</p>';

        $sql3 = "SELECT * FROM passager WHERE trajet_id = ?";
        $stmt3 = $dbh->prepare($sql3);
        $stmt3->bind_param("s", $trajet['id']);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $num_rows = $result3->num_rows;

        if ($num_rows == 0) {
            echo '<details>';
            echo '<summary>Passagers ('.$num_rows.')</summary>';
            echo '<p>Aucun passager</p>';
            echo '</details>';
        } else {
            echo '<details open>';
            echo '<summary>Passagers ('.$num_rows.')</summary>';
            echo '<div>';
        
            while ($passager = $result3->fetch_assoc()) {
                $sql4 = "SELECT * FROM profil WHERE id = ?";
                $stmt4 = $dbh->prepare($sql4);
                $stmt4->bind_param("s", $passager['user_id']);
                $stmt4->execute();
                $result4 = $stmt4->get_result();
                $passager = $result4->fetch_assoc();
        
                echo '<p>'.$passager['prenom'].' '.$passager['nom'].'</p>';
            }
        
            echo '</details>';
            echo '</div>';
        }
        echo '</div>';

        while($interior = $result5->fetch_assoc()) {
            //Trajet ou l'utilisateur est passager
            $interior['date'] = new DateTime($interior['date']);
            $interior['date'] = $interior['date']->format('d/m/Y H:i');
    
            $minutes = $interior['duree'] * 60;
            $hours = floor($minutes / 60);
            $minutes = $minutes - ($hours * 60);
            $minutes = round($minutes / 60 * 60);
    
            $interior['duree'] = $hours.'h'.$minutes;
    
            $sql2 = "SELECT * FROM profil WHERE id = ?";
            $stmt2 = $dbh->prepare($sql2);
            $stmt2->bind_param("s", $interior['conducteur_id']);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $conducteur = $result2->fetch_assoc();


    
            
            echo '<div>';

            $sql3 = "SELECT * FROM passager WHERE trajet_id = ?";
            $stmt3 = $dbh->prepare($sql3);
            $stmt3->bind_param("s", $interior['id']);
            $stmt3->execute();
            $result3 = $stmt3->get_result();
            $num_rows = $result3->num_rows;            
    
            echo '<h3>Conducteur:'. $conducteur["prenom"].' '.$conducteur["nom"].'</h3>';
            echo '<p> Lieu départ:'.$interior['lieu_depart'].'</p>';
            echo '<p> Lieu arrivé:'.$interior['lieu_arrivee'].'</p>';
            echo '<p> Date:'.$interior['date'].'</p>';
            echo '<p>Durée: '.$interior['duree'].' | KM: '.$interior['km'].'km | CO2: '.$interior['co2'].'kg</p>';
            echo '<p> Nombre de place:'.$num_rows.'/'.$interior['place'].'</p>';

            echo '<details>';
            echo '<summary>';
            
            if ($num_rows == 0) {
                echo 'Passagers ('.$num_rows.')';
            } else {
                echo 'Passager ('.$num_rows.')';
            }
            
            echo '</summary>';
            echo '<div>';
            
            if ($num_rows == 0) {
                echo '<p>Aucun passager</p>';
            } else {
                while ($passager = $result3->fetch_assoc()) {
                    $sql4 = "SELECT * FROM profil WHERE id = ?";
                    $stmt4 = $dbh->prepare($sql4);
                    $stmt4->bind_param("s", $passager['user_id']);
                    $stmt4->execute();
                    $result4 = $stmt4->get_result();
                    $passager = $result4->fetch_assoc();
            
                    echo '<p>'.$passager['prenom'].' '.$passager['nom'].'</p>';
                }
            }
            
            echo '</div>';
            echo '</details>';
            

            echo '</div>';
        }

    }
    echo '</div>';

    $sql = "SELECT * FROM trajet WHERE conducteur_id = ? AND date < NOW() ORDER BY date ASC";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("s", $user['id']);
    $stmt->execute();

    $result = $stmt->get_result();
    $number = $result->num_rows;

    $sql2 = 'SELECT * FROM passager INNER JOIN trajet ON passager.trajet_id = trajet.id WHERE passager.user_id = ? AND trajet.date < NOW() ORDER BY trajet.date ASC';
    $stmt2 = $dbh->prepare($sql2);
    $stmt2->bind_param("s", $user['id']);
    $stmt2->execute();

    $result2 = $stmt2->get_result();
    $number2 = $result2->num_rows;

    $number = $number + $number2;

    if($number == 0) {

    } else {
        echo '<h2>Vos trajets terminés ('. $number. ')</h2>';
    }

    echo '<div id="card-lister">';
    while($trajet = $result->fetch_assoc()) {
        echo '<div class="card">';
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

        $sql3 = "SELECT * FROM passager WHERE trajet_id = ?";
        $stmt3 = $dbh->prepare($sql3);
        $stmt3->bind_param("s", $trajet['id']);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $num_rows = $result3->num_rows;
        
        

        echo '<h3>Conducteur:'. $conducteur["prenom"].' '.$conducteur["nom"].'</h3>';
        echo '<p> Lieu départ:'.$trajet['lieu_depart'].'</p>';
        echo '<p> Lieu arrivé:'.$trajet['lieu_arrivee'].'</p>';
        echo '<p> Date:'.$trajet['date'].'</p>';
        echo '<p>Durée: '.$trajet['duree'].' | KM: '.$trajet['km'].'km | CO2: '.$trajet['co2'].'kg</p>';
        echo '<p> Nombre de place:'.$num_rows. '/'.$trajet['place'].' passager(s)</p>';
        echo '</div>';

    }

    while($trajet = $result2->fetch_assoc()) {
        echo '<div class="card">';
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

        $sql3 = "SELECT * FROM passager WHERE trajet_id = ?";
        $stmt3 = $dbh->prepare($sql3);
        $stmt3->bind_param("s", $trajet['id']);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $num_rows = $result3->num_rows;
        
        

        echo '<h3>Conducteur:'. $conducteur["prenom"].' '.$conducteur["nom"].'</h3>';
        echo '<p> Lieu départ:'.$trajet['lieu_depart'].'</p>';
        echo '<p> Lieu arrivé:'.$trajet['lieu_arrivee'].'</p>';
        echo '<p> Date:'.$trajet['date'].'</p>';
        echo '<p>Durée: '.$trajet['duree'].' | KM: '.$trajet['km'].'km | CO2: '.$trajet['co2'].'kg</p>';
        echo '<p> Nombre de place:'.$num_rows. '/'.$trajet['place'].' passager(s)</p>';
        echo '</div>';

    }







?>
</main>

</body>
</html>