<?php
session_start();

// if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])) {

// } else {
//   $_SESSION['error'] = 'Vous devez être connecté pour accéder à cette page';
//   header('Location: ./index.php');
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/header-footer.css">
    <link rel="stylesheet" href="./assets/css/trajets.css">
</head>
<body>
    
<?php

require_once 'customnav.php';
require_once 'header.php';

if(isset($_SESSION['error'])){
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}

?>



<div class="form-trajets">
<form style='margin-top: 70px' method='POST' action='./assets/php/vtrajet.php'>
    <label for="address">Départ :</label>
    <input type="text" name='depart' id="address" placeholder="Départ" required>
    <label for="adess2">Arrivée :</label>
    <input id='adress2' name='arrivee' type="text" placeholder="Arrivée" required>
    <label for="datetime">Date :</label>
    <input id="datetime" type="datetime-local" name='datetime' onclick="" required>
    <label for="place">Nombre de places :</label>
    <select id="place" name='place' required>
        <option value="">Nombre de places</option>
        <option value="1">1 place</option>
        <option value="2">2 places</option>
        <option value="3">3 places</option>
        <option value="4">4 places</option>
        <option value="5">5 places</option>
        <option value="6">6 places</option>
    </select>


    <input type="hidden" name='lat' id="lat" value="">
    <input type="hidden" name='lng' id="lng" value="">

    <input type="hidden" name='lat2' id="lat2" value="">
    <input type="hidden" name='lng2' id="lng2" value="">

    <input type="hidden" name='duree' id="duree" value="">
    <input type="hidden" name='co2' id="co2" value="">
    <input type="hidden" name='km' id="km" value="">

    <input type="submit" value="Ajouter le trajet" onclick='waiting()'>

</form>
  
</div>

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

      document.querySelector('form').action = './assets/php/vtrajet.php?co2=' + round(co2Emission) + '&km=' + round(distanceInKm) + '&duree=' + round(durationInHours);


    } else {
        console.log("Error: " + status);
    }
  });
}

function calculateCO2Emission(distanceInKm) {
  var co2Emission = distanceInKm * 150 / 1000;
  return co2Emission;
}

function waiting() {
if(document.getElementById('lat').value == "" || document.getElementById('lng').value == "" || document.getElementById('lat2').value == "" || document.getElementById('lng2').value == "") {
    return;
}

calculateDistanceAndCO2();
event.preventDefault();

alert('Veuillez patienter pendant le calcul de la distance et de la durée du trajet.');

setTimeout(function() {
    document.querySelector('form').submit();
}, 2000);

}

</script>


<?php
  require_once 'footer.php';
  require_once 'menu.php'
?>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete&language=fr&components=country:FR&key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo" async defer></script>


</body>
</html>