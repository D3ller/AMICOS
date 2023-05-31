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
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete&language=fr&output=json&key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo" async defer></script>
</head>
<body>
    <?php 
    require_once 'header.php';
    ?>
    

    <main>


<input type="text" id="address" placeholder="Départ">
<input id='adress2' type="text" placeholder="Arrivée">
<input type="datetime-local" value="Date" onclick="">
<input type="submit" value="Rechercher">


<input type="hidden" id="lat" value="">
<input type="hidden" id="lng" value="">

<input type="hidden" id="lat2" value="">
<input type="hidden" id="lng2" value="">

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



    
    <?php
    require_once 'footer.php';
    ?>

    <script>





</script>
    
</body>
</html>