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




    <main>





        <form action="/assets/php/recherche_trajet.php" method="post" required>
        <input type="text" name='depart' id="address" placeholder="Départ" required >
        <input id='adress2' name='arrivee' type="text" placeholder="Arrivée" required>
        <input type="datetime-local" name='datetime' value="Date" onclick="" required>

        <input name='lat' type="hidden" id="lat" value="" required>
        <input name='lng' type="hidden" id="lng" value="" required>

        <input name='lat2' type="hidden" id="lat2" value="" required>
        <input name='lng2' type="hidden" id="lng2" value="" required>

        <input type="submit" value="Rechercher">
        </form>



        <p id='c02'></p>
        <p id='distance'></p>
        <p id='duree'></p>

        <button onclick="calculateDistanceAndCO2()">Calculer</button>

        <?php

        require_once './assets/php/lib.php';

        $dbh = connect();

$sql = "SELECT t.*, COUNT(p.id) AS num_rows
        FROM trajet t
        LEFT JOIN passager p ON t.id = p.trajet_id
        WHERE t.date > NOW()
        GROUP BY t.id
        HAVING num_rows < t.place
        ORDER BY RAND()
        LIMIT 5";

        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<h2>Trajets récents</h2>';
        echo '<div id="trajets">';

        while ($row = $result->fetch_assoc()) {
            echo '<div class="trajet">';
            echo "<p>".$row['lieu_depart']."</p>";
            echo "<p>".$row['lieu_arrivee']."</p>";
            echo "<p>".$row['date']."</p>";
            echo "<p>".$row['num_rows']."/".$row['place']."</p>";
            echo '<a href="./reserv/'.$row['id'].'">Voir</a>';
            echo '</div>';
        }

        echo '</div>';


        ?>



<?php

$sqluser = "SELECT * FROM profil WHERE email = ? AND id = ?";
$stmtuser = $dbh->prepare($sqluser);
$stmtuser->bind_param("ss", $_SESSION['AMIMAIL'], $_SESSION['AMIID']);
$stmtuser->execute();
$resultuser = $stmtuser->get_result();
$user = $resultuser->fetch_assoc();


$sql = "SELECT * FROM passager WHERE user_id = ? AND NOW() > (SELECT date FROM trajet WHERE id = passager.trajet_id) LIMIT 1";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
$trajet = $result->fetch_assoc();

if($result->num_rows > 0) {
echo '<h2>Votre dernier trajet</h2>';
$sql2 = "SELECT * FROM trajet WHERE id = ?";
$stmt2 = $dbh->prepare($sql2);
$stmt2->bind_param("i", $trajet['trajet_id']);
$stmt2->execute();
$result2 = $stmt2->get_result();
$trajet2 = $result2->fetch_assoc();

$trajet2['date'] = date("d/m/Y H:i", strtotime($trajet2['date']));

echo "Départ de ".$trajet2['lieu_depart']. " vers ". $trajet2['lieu_arrivee']." le ". $trajet2['date'];
echo '<div id="map" style="width: 80%; height: 200px; border-radius: 20px; margin: 0 auto;"></div>';
echo "
<script>
var latDepart = $trajet2[lat];
var lngDepart = $trajet2[lng];
var latArrivee = $trajet2[lat2];
var lngArrivee = $trajet2[lng2];

function initMap() {
  var startPoint = new google.maps.LatLng(latDepart, lngDepart);
  var endPoint = new google.maps.LatLng(latArrivee, lngArrivee);

  var mapOptions = {
    center: startPoint,
    zoom: 50,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    disableDefaultUI: true,
    mapTypeControl: false,
    mapTypeControlOptions: {
      mapTypeIds: []
    }
  };

  var map = new google.maps.Map(document.getElementById('map'), mapOptions);

  var directionsService = new google.maps.DirectionsService();
  var directionsRenderer = new google.maps.DirectionsRenderer({
    map: map,
    polylineOptions: {
      strokeColor: '#fe1269'
    }
  });

  var request = {
    origin: startPoint,
    destination: endPoint,
    travelMode: google.maps.TravelMode.DRIVING 
  };

  directionsService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsRenderer.setDirections(result);
    }
  });
}

window.onload = function() {
  initMap();
  map.getDiv().style.width = '100%';
map.getDiv().style.height = '100px';
};



</script>
";
} else {
echo '<h2>Vous n\'avez aucun trajet passés</h2>';
echo '<a href="./recherche">Rechercher un trajet</a>';
}


if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){

echo '
<div id="swipe">
    <div class="tinder">
        <div class="tinder--status">
            <i class="fa fa-remove"></i>
            <i class="fa fa-heart"></i>
        </div>

        <div class="tinder--cards">
            <div class="tinder--card">
                <img src="https://placeimg.com/600/300/people">
                <h3>Demo card 3</h3>
                <p>This is a demo for Tinder like swipe cards</p>
            </div>
            <div class="tinder--card">
                <img src="https://placeimg.com/600/300/people">
                <h3>Demo card 3</h3>
                <p>This is a demo for Tinder like swipe cards</p>
            </div>
            <div class="tinder--card">
                <img src="https://placeimg.com/600/300/people">
                <h3>Demo card 3</h3>
                <p>This is a demo for Tinder like swipe cards</p>
            </div>
            <div class="tinder--card">
                <img src="https://placeimg.com/600/300/people">
                <h3>Demo card 3</h3>
                <p>This is a demo for Tinder like swipe cards</p>
            </div>
            <div class="tinder--card">
                <img src="https://placeimg.com/600/300/people">
                <h3>Demo card 3</h3>
                <p>This is a demo for Tinder like swipe cards</p>
            </div>
            <div class="tinder--card">
                <img src="https://placeimg.com/600/300/people">
                <h3>Demo card 3</h3>
                <p>This is a demo for Tinder like swipe cards</p>
            </div>
            <div class="tinder--card">
                <img src="https://placeimg.com/600/300/people">
                <h3>Demo card 3</h3>
                <p>This is a demo for Tinder like swipe cards</p>
            </div>

            <div class="tinder--card">
                <img src="https://placeimg.com/600/300/animals">
                <h3>Demo card 2</h3>
                <p>This is a demo for Tinder like swipe cards</p>
            </div>
            <div class="tinder--card">
                <img src="https://placeimg.com/600/300/nature">
                <h3>Demo card 3</h3>
                <p>This is a demo for Tinder like swipe cards</p>
            </div>
            <div class="tinder--card">
                <img src="https://placeimg.com/600/300/tech">
                <h3>Demo card 4</h3>
                <p></p>
            </div>
            <div class="tinder--card">
                <img src="https://placeimg.com/600/300/arch">
                <h3>Demo card 5</h3>
                <p>This is a demo for Tinder like swipe cards</p>
            </div>
        </div>

        <div class="tinder--buttons">
            <button id="nope"><i class="fa fa-remove"></i></button>
            <button id="love"><i class="fa fa-heart"></i></button>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
</div>';

} else {
    echo '<h2>Connectez-vous pour voir les trajets</h2>';
}

?>

</main>

<?php

    require_once 'footer.php';
    ?>
    
</body>
</html>