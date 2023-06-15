<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type='text/css' rel='stylesheet' href='/assets/css/parkings.css'>
    <link type='text/css' rel='stylesheet' href='/assets/css/header-footer.css'>
    <title>Document</title>
</head>
<body>
    <?php

require_once 'customnav.php';
require_once 'header.php';

require_once './assets/php/lib.php';

$dbh = connect();

$sql = "SELECT * FROM parking";
$result = $dbh->query($sql);

$num_rows = $result->num_rows;

echo "<p id='pk'>Il y a " . $num_rows . " parkings enregistrés</p>";

?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo&callback=initMap" async defer></script>
<script>
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 46.227638, lng: 2.213749},
        zoom: 6,
        disableDefaultUI: true
    });

    <?php
    while ($row = $result->fetch_assoc()) {
        echo "(function() {"; // Début de la fonction anonyme auto-exécutée
        echo "var marker = new google.maps.Marker({";
        echo "position: {lat: " . $row['lat'] . ", lng: " . $row['lng'] . "},";
        echo "map: map,";
        echo "title: '" . $row['name'] . "',";
        echo "icon: 'https://portfolio.karibsen.fr/assets/img/parkpin.svg'";
        echo "});";
    
        echo "marker.addListener('click', function() {";
        echo "var infoWindow = new google.maps.InfoWindow({";
        echo "content: '" . $row['name'] . "'";
        echo "});";
        echo "infoWindow.open(map, marker);";
        echo "});";
        echo "})();"; // Fin de la fonction anonyme auto-exécutée
    }
    ?>
}
</script>

<div id="map"></div>

<style>
    #map {
        height: 400px;
        margin: 0 20px;
    }
</style>

<?php
require_once('menu.php');
require_once('footer.php');
?>

</body>
</html>
