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
    <script src="./assets/js/script.js" DEEFER></script>
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

        <?php

        if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMINAME'])){

            $dbh = connect();

            $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
            $stmt = $dbh->prepare($sql);
            $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();    

            echo "<p class='header-p-white'>Bienvenue ".$user['prenom']." <a href='./assets/php/deconnexion.php'>Déconnexion</a></p>";
        } else {
            echo "<a class='info-con' href='./connexion.php'>Connexion</a>";
            echo ' | ';
            echo "<a class='info-con' href='./inscription.php'>Inscription</a>";
            echo ' | ';
            echo "<a class='info-con' href='./forget.php'>Mot de passe oublié</a>";
        }
        ?>

    </main>

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
        GROUP BY t.id
        HAVING num_rows < t.place WHERE t.date > NOW()
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



<script type="text/javascript">
  function initAutocomplete() {
    var address = document.getElementById('address');
    var autocomplete = new google.maps.places.Autocomplete(address);

    var address2 = document.getElementById('adress2');
    var autocomplete2 = new google.maps.places.Autocomplete(address2);

    autocomplete.addListener('place_changed', function() {
      var place = autocomplete.getPlace();
      var latitude = place.geometry.location.lat();
      var longitude = place.geometry.location.lng();
      document.getElementById('lat').value = latitude;
      document.getElementById('lng').value = longitude;
    });

    autocomplete2.addListener('place_changed', function() {
      var place = autocomplete2.getPlace();
      var latitude = place.geometry.location.lat();
      var longitude = place.geometry.location.lng();
      document.getElementById('lat2').value = latitude;
      document.getElementById('lng2').value = longitude;
    });

  }

</script>


<script>


    

function calculateDistanceAndCO2() {
  var lat1 = parseFloat(document.getElementById('lat').value);
  var lng1 = parseFloat(document.getElementById('lng').value);
  var lat2 = parseFloat(document.getElementById('lat2').value);
  var lng2 = parseFloat(document.getElementById('lng2').value);



  var origin = new google.maps.LatLng(lat1, lng1);
  var destination = new google.maps.LatLng(lat2, lng2);

  var service = new google.maps.DirectionsService();
  var request = {
    origin: origin,
    destination: destination,
    travelMode: google.maps.TravelMode.DRIVING
  };

  service.route(request, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      var route = response.routes[0];
      var distance = 0;
      var duration = 0;

      for (var i = 0; i < route.legs.length; i++) {
        distance += route.legs[i].distance.value;
        duration += route.legs[i].duration.value;
      }

      var distanceInKm = distance / 1000;
      var durationInHours = duration / 3600;

      var co2Emission = calculateCO2Emission(distanceInKm);
      var round = function(value) {
        return Math.round(value * 100) / 100;
      };

        document.getElementById('distance').innerHTML = "Distance : " + round(distanceInKm) + " km";

        var minutes = durationInHours * 60;
        var hours = Math.floor(minutes / 60);
        var minutes = minutes - (hours * 60);
        document.getElementById('duree').innerHTML = "Durée : " + hours + " heures et " + Math.round(minutes) + " minutes";
        document.getElementById('c02').innerHTML = "CO2 : " + round(co2Emission) + " kg";
        console.log(durationInHours);


    } else {
        document.getElementById('distance').innerHTML = "Le trajet n'a pas pu être calculé.";
        console.log(status);
    }
  });
}

function calculateCO2Emission(distanceInKm) {
  var co2Emission = distanceInKm * 150 / 1000;
  return co2Emission;
}



</script>



    
    <?php
    require_once 'footer.php';
    ?>

    <script>





</script>
    
</body>
</html>