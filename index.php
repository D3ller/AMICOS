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
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/header-footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="./assets/js/index.js" DEFER></script>
    <title>Accueil</title>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete&language=fr&output=json&region=FR&key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo" async defer></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo&libraries=places,geometry&region=FR"></script>


</head>
<body>
    <?php 
    require_once 'header.php';

    if(isset($_SESSION['error'])) {
        echo '<p class="error">'.$_SESSION['error'].'</p>';
        unset($_SESSION['error']);
    }
    ?>

<?php

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){
    $dbh = connect();
    $sql = 'SELECT * FROM profil WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("i", $_SESSION['AMIID']);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();
    echo '<p>Bienvenue '.$user['prenom'].'.</p>';
}

?>
    <main class="main-index">
        <div class="form-index">
            <form action="/assets/php/recherche_trajet.php" method="post" required>
                <div class="haut-form-index">
                    <div class="barre-form-index"></div>
                    <input type="text" name='depart' id="address" placeholder="Départ" required >
                    <input id='adress2' name='arrivee' type="text" placeholder="Arrivée" required>
                </div>
                <div class="bas-form-index">
                    <div class="barre-form-index"></div>

                    <div class="custom-date-input">
                        <label for="date-input">
                            <img src="https://portfolio.karibsen.fr/assets/img/calendar.svg" alt="Calendrier" class="calendar-icon">
                            <span>Quand ?</span>
                        </label>
                        <input type="date" id="date-input">
                    </div>
                    <!-- <input type="datetime-local" name='datetime' value="Date" onclick="" required> -->
                    <input type="number" name='place' placeholder="Nombre de place" min="1" max="7" required>
                </div>

                <input name='lat' type="hidden" id="lat" value="" required>
                <input name='lng' type="hidden" id="lng" value="" required>

                <input name='lat2' type="hidden" id="lat2" value="" required>
                <input name='lng2' type="hidden" id="lng2" value="" required>

                <input type="submit" value="Rechercher">
            </form>
        </div>

</main>

<?php
    require_once 'menu.php';

    require_once 'footer.php';
    ?>
    
</body>
</html>