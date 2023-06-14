<?php
session_start();


if(!isset($_SESSION['AMIID']) || !isset($_SESSION['AMIMAIL'])) {
    $_SESSION['error'] = "Vous n'avez pas le droit de réserver un trajet sans être connecté";
    header('Location: ../connexion.php');
    exit();

}

$id = $_GET['id'];

if(!isset($id)) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver un trajet sans avoir sélectionné un trajet";
    header('Location: ../');
    exit();

}

require_once './assets/php/lib.php';

$dbh = connect();

$sql = "SELECT * FROM trajet WHERE id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$trajet = $result->fetch_assoc();

if($result->num_rows == 0) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver un trajet qui n'existe pas";
    header('Location: ../');
    exit();

}

$sqluser = "SELECT * FROM profil WHERE email = ? AND id = ?";
$stmtuser = $dbh->prepare($sqluser);
$stmtuser->bind_param("ss", $_SESSION['AMIMAIL'], $_SESSION['AMIID']);
$stmtuser->execute();
$resultuser = $stmtuser->get_result();
$user = $resultuser->fetch_assoc();

if($trajet['conducteur_id'] == $user['id']) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver votre propre trajet";
    header('Location: ../');
    exit();

}

$sql = "SELECT * FROM passager WHERE user_id = ? AND trajet_id = ?";    
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ii", $user['id'], $trajet['id']);
$stmt->execute();
$result = $stmt->get_result();
$passager = $result->fetch_assoc();

if($result->num_rows > 0) {
    $_SESSION['error'] = "Vous ne pouvez pas réserver un trajet que vous avez déjà réservé";
    header('Location: ../');
    exit();

}

$sql = "SELECT COUNT(*) AS num_rows FROM passager WHERE trajet_id = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $trajet['id']);
$stmt->execute();
$result = $stmt->get_result();
$passagers = $result->fetch_assoc();

echo "<!DOCTYPE html>";
echo "<html lang='fr'>";
echo "  <head>";
echo "    <meta charset='utf-8'>";
echo "    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>";
echo "    <meta name='description' content=''>";
echo "    <meta name='author' content=''>";
echo "    <link type='text/css' rel='stylesheet' href='/assets/css/header-footer.css'>";
echo "    <link type='text/css' rel='stylesheet' href='/assets/css/reservation.css'>";
echo '<script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete&language=fr&output=json&region=FR&key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo" async defer></script>';
echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo&libraries=places,geometry&region=FR"></script>';

echo "    <title>Réservation</title>";
echo "  </head>";

echo "  <body>";

require_once('customnav.php'); 

echo '<main>';


$conducteursql = "SELECT * FROM profil WHERE id = ?";
$stmtconducteur = $dbh->prepare($conducteursql);
$stmtconducteur->bind_param("i", $trajet['conducteur_id']);
$stmtconducteur->execute();
$resultconducteur = $stmtconducteur->get_result();
$conducteur = $resultconducteur->fetch_assoc();

echo '<div class="container-conducteur">';
echo '<img src="'.$conducteur['profil-picture'].'" alt="road" class="road">';
echo '<div class="conducteur-text">';
echo '<h1>'.$conducteur['prenom'].' '.$conducteur['nom'].'</h1>';
echo '<p>'.$trajet['lieu_depart'].' ➔ ' . $trajet['lieu_arrivee'].' </p>';

$minutes = $trajet['duree'] * 60;
$hours = floor($minutes / 60);
$minutes = $minutes - ($hours * 60);
$minutes = round($minutes / 60 * 60);

$minutes = sprintf("%02d", $minutes);

$trajet['duree'] = $hours.'h'.$minutes;
echo '<p>Durée: <span class="bold">'.$trajet['duree'].'</span></p>';

$heure_trajet = date('H', strtotime($trajet['date']));

$heure_total = $heure_trajet + $hours;

$minutes_trajet = date('i', strtotime($trajet['date']));

$minutes_total = $minutes_trajet + $minutes;

if ($minutes_total >= 60) {
    $heure_total += floor($minutes_total / 60);
    $minutes_total = $minutes_total % 60;
}

if($heure_total >= 24) {
    $heure_total = $heure_total % 24;
}

$heure_minutes_total = sprintf("%02d:%02d", $heure_total, $minutes_total);

$heures_minutes_depart = date('H:i', strtotime($trajet['date']));

list($heures, $minutes) = explode(':', $heures_minutes_depart);

if ($minutes < 10) {
    $minutes = '0' . $minutes;
}

$heures_minutes_depart = $heures . ':' . $minutes;

echo '<p>Heure de départ: <span class="bold">'.$heures_minutes_depart.'</span></p>';

echo '<p>Heure d\'arrivée: <span class="bold">'.$heure_minutes_total.'</span></p>';


echo '</div>';
echo '</div>';

echo '<div class="container-reservation">';
echo 'Le trajet commencera au parking de '. $trajet['lieu_depart'] .', où vous pourrez facilement garer votre véhicule avant de prendre la route en direction de '. $trajet['lieu_arrivee'] .'.';
echo '</div>';

echo '
<div id="map" style="width: 100%; height: 400px; border-radius: 20px; margin: 0 auto;"></div>

<script>
var latDepart = '.$trajet['lat'].';
var lngDepart = '.$trajet['lng'].';
var latArrivee = '.$trajet['lat2'].';
var lngArrivee = '.$trajet['lng2'].';

function initMap() {
  var startPoint = new google.maps.LatLng(latDepart, lngDepart);
  var endPoint = new google.maps.LatLng(latArrivee, lngArrivee);

  var mapOptions = {
    center: startPoint,
    zoom: 12,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    disableDefaultUI: true,
    mapTypeControl: false,
    mapTypeControlOptions: {
      mapTypeIds: []
    }
  };

  var map = new google.maps.Map(document.getElementById("map"), mapOptions);

  var directionsService = new google.maps.DirectionsService();
  var directionsRenderer = new google.maps.DirectionsRenderer({
    map: map,
    polylineOptions: {
      strokeColor: "#6d6d6c"
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
  var mapElement = document.getElementById("map");
  mapElement.style.width = "100%";
  mapElement.style.height = "400px";
};
</script>';

?>

<a class="resa-button" href="/assets/php/vreservation.php?id=<?php echo $trajet['id']; ?>">

<?php

if($passagers['num_rows'] >= $trajet['place']) {
    echo '<button class="btn-reservation" disabled>Complet</button>';
} else {
    echo '<button class="btn-reservation">Réserver</button>';
}

?>
</a>
<script>
  const buttonResa= document.getElementByClassName('btn-reservation');

  buttonResa.addEventListener('animationend', () => {
    button.blur();
  });
</script>

</main>

<?php
require_once 'footer.php';
?>
</body>

<?php

// $sql = "INSERT INTO passager (user_id, trajet_id) VALUES (?, ?)";
// $stmt = $dbh->prepare($sql);
// $stmt->bind_param("ii", $user['id'], $trajet['id']);
// $stmt->execute();

// $_SESSION['error'] = "Vous avez réservé un trajet";
// header('Location: ../profil');
// exit();
?>