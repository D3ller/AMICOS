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
    <script src="./assets/js/index.js" defer></script>
    <title>Accueil</title>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete&language=fr&output=json&region=FR&key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo" async defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo&libraries=places,geometry&region=FR"></script>
</head>
<body>
    <?php 
    if(isset($_SESSION['error'])) {
        echo '<p class="error">'.$_SESSION['error'].'</p>';
        unset($_SESSION['error']);
    }


    require_once 'customnav.php';

    ?>
<main>

<?php

$agent_utilisateur = $_SERVER['HTTP_USER_AGENT'];

$is_mobile = false;



if (strpos($agent_utilisateur, 'Mobile') !== false || strpos($agent_utilisateur, 'Android') !== false || strpos($agent_utilisateur, 'iPhone') !== false || strpos($agent_utilisateur, 'iPad') !== false || strpos($agent_utilisateur, 'iPod') !== false || strpos($agent_utilisateur, 'BlackBerry') !== false || strpos($agent_utilisateur, 'Windows Phone') !== false) {
    $is_mobile = true;
}

if ($is_mobile) {
    $action = "/assets/php/swipe.php";

} else {
    $action = "/assets/php/recherche_trajet.php";
}
?>

    <form action="<?php echo $action; ?>" method="post" required>
    <input type="text" name='depart' id="address" placeholder="Départ" required >
                    <input id='adress2' name='arrivee' type="text" placeholder="Arrivée" required>
                    <input type="date" name='date' id="date" placeholder="Date" required>
                    <select name='place' min="1" max="7" id="passager" required>
                        <option value="1">1 passager</option>
                        <option value="2">2 passagers</option>
                        <option value="3">3 passagers</option>
                        <option value="4">4 passagers</option>
                        <option value="5">5 passagers</option>
                        <option value="6">6 passagers</option>
                        <option value="7">7 passagers</option>
                    </select>

                    <input name='lat' type="hidden" id="lat" value="" required>
                <input name='lng' type="hidden" id="lng" value="" required>
                <input name='lat2' type="hidden" id="lat2" value="" required>
                <input name='lng2' type="hidden" id="lng2" value="" required>

                    <input type="submit" value="Rechercher">

</form>

<button id='reverse' onclick="reverse()">Inverser</button>

</main>
<?php
    require_once 'footer.php';
    ?>

    <script>
        function reverse() {
            var depart = document.getElementById('address').value;
            var arrivee = document.getElementById('adress2').value;
            document.getElementById('address').value = arrivee;
            document.getElementById('adress2').value = depart;

            var lat = document.getElementById('lat').value;
            var lng = document.getElementById('lng').value;
            var lat2 = document.getElementById('lat2').value;
            var lng2 = document.getElementById('lng2').value;
            document.getElementById('lat').value = lat2;
            document.getElementById('lng').value = lng2;
            document.getElementById('lat2').value = lat;
            document.getElementById('lng2').value = lng;
        }

        </script>
    
</body>
</html>
