<?php
session_start();
require_once('./assets/php/lib.php');

ini_set('display_errors', 0);

$depart = $_POST['depart'];
$arrivee = $_POST['arrivee'];
$datetime = $_POST['date'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$lat2 = $_POST['lat2'];
$lng2 = $_POST['lng2'];

$dateFormat = 'd/m/Y';


$dateTimeObj = DateTime::createFromFormat($dateFormat, $datetime);
$datetime = $dateTimeObj->format('Y-m-d H:i:s');

if(!isset($depart) || !isset($arrivee) || !isset($datetime) || !isset($lat) || !isset($lng) || !isset($lat2) || !isset($lng2)){
    $_SESSION['error'] = 'Veuillez remplir tous les champs';
    header('Location: /index.php');
    exit();
}

if($depart == $arrivee){
    $_SESSION['error'] = 'Le départ et l\'arrivée ne peuvent pas être identiques';
    header('Location: /index.php');
    exit();
}

if($datetime < date('Y-m-d H:i:s')){
    $_SESSION['error'] = 'La date ne peut pas être antérieure à la date actuelle';
    header('Location: /index.php');
    exit();
}

if(!is_numeric($lat) || !is_numeric($lng) || !is_numeric($lat2) || !is_numeric($lng2)){
    $_SESSION['error'] = 'Les coordonnées GPS ne sont pas valides';
    header('Location: /index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type='text/css' rel='stylesheet' href='/assets/css/match.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type='text/css' rel='stylesheet' href='/assets/css/header-footer.css'>
    <!--  -->
    <title>Match</title>
</head>
<body>

<?php
require_once('customnav.php');
require_once 'header.php';
?>
<main>

<?php 

echo '<h1 id="search-h1">Recherche de trajet entre '. $depart. ' et '. $arrivee .'</h1>';

$dbh = connect();


$sql = "SELECT * FROM trajet WHERE date > ? AND place <= ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("si", $datetime, $_POST['place']);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = $result->num_rows;

if($num_rows == 0){
    echo '<p id="none">Aucun trajet n\'a été trouvé</p>';
    exit();
}

$trajetInteressant = null;
$distancePlusInteressante = null;

while ($trajet = $result->fetch_assoc()) {


    $apiUrl = 'https://maps.googleapis.com/maps/api/directions/json?origin='.$lat.','.$lng.'&destination='.$lat2.','.$lng2.'&waypoints='.$trajet['lat'].','.$trajet['lng'].'|'.$trajet['lat2'].','.$trajet['lng2'].'&key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo';
    $response = file_get_contents($apiUrl);
    $directions = json_decode($response, true);



    if ($directions['status'] === 'OK') {
        $distance = $directions['routes'][0]['legs'][2]['distance']['value'];
        $distance = $distance / 1000;

if ($distance <= 20) {
    if ($trajetInteressant === null || abs($distance) < $distancePlusInteressante) {
        $trajetInteressant = $trajet;
        $distancePlusInteressante = abs($distance);
    }
}
    } else {
        echo 'Erreur lors de la récupération du trajet.';
    }
}

?>

    <div class="tinder">
        <div class="tinder--status">
            <i class="fa fa-remove"></i>
            <i class="fa fa-heart"></i>
        </div>
        <?php
if ($trajetInteressant !== null) {
            ?>
        <div class="tinder--cards">

            <div data-link="https://mmi22c01.sae202.ovh/reserv/<?php echo $trajetInteressant['id']; ?>" class="tinder--card">

                <?php

                $sqluser = "SELECT * FROM profil WHERE id = ?";
                $stmtuser = $dbh->prepare($sqluser);
                $stmtuser->bind_param("i", $trajetInteressant['conducteur_id']);
                $stmtuser->execute();
                $resultuser = $stmtuser->get_result();
                $conducteur = $resultuser->fetch_assoc();

                echo '<img id="pics" src="'.$conducteur['profil-picture'].'" alt="Photo de profil" class="photo-profil">';
                echo '<p id="cdt-name">'.$conducteur['prenom'].' '.$conducteur['nom'].'</p>';
                echo '<p id="trajet">'.$trajetInteressant['lieu_depart'].' ➔ '.$trajetInteressant['lieu_arrivee'].' | '.$trajetInteressant['duree'].'</p>';

                $sqls = "SELECT * FROM passager WHERE trajet_id = ?";
                $stmts = $dbh->prepare($sqls);
                $stmts->bind_param("i", $trajetInteressant['id']);
                $stmts->execute();
                $results = $stmts->get_result();
                $num_rows = $results->num_rows;
            
                echo '<p id="place">Place restante :'.$num_rows.'/'.$trajetInteressant['place'].'</p>';
            
                if($num_rows == $trajetInteressant['place']){
                    $complete = 'disabled';
                } else {
                    $complete = '';
                }
                ?>

            </div>

            <?php

$result->data_seek(0); 
while ($trajet = $result->fetch_assoc()) {
    if ($trajet === $trajetInteressant) {
        continue;
    }

    $apiUrl = 'https://maps.googleapis.com/maps/api/directions/json?origin='.$lat.','.$lng.'&destination='.$lat2.','.$lng2.'&waypoints='.$trajet['lat'].','.$trajet['lng'].'|'.$trajet['lat2'].','.$trajet['lng2'].'&key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo';
    $response = file_get_contents($apiUrl);
    $directions = json_decode($response, true);

    if ($directions['status'] === 'OK') {

        $distance = $directions['routes'][0]['legs'][2]['distance']['value'];
        $distance = $distance / 1000;

        if($distance == 0) {
            continue;
        }

        if($distance < 50) {


    ?>
            <div data-link="https://mmi22c01.sae202.ovh/reserv/<?php echo $trajet['id']; ?>" class="tinder--card">


            <?php

$sqluser = "SELECT * FROM profil WHERE id = ?";
$stmtuser = $dbh->prepare($sqluser);
$stmtuser->bind_param("i", $trajet['conducteur_id']);
$stmtuser->execute();
$resultuser = $stmtuser->get_result();
$conducteur = $resultuser->fetch_assoc();

$minutes = $trajet['duree'] * 60;
$hours = floor($minutes / 60);
$minutes = $minutes - ($hours * 60);
$minutes = round($minutes / 60 * 60);

$minutes = sprintf("%02d", $minutes);

$trajet['duree'] = $hours . 'h' . $minutes;

echo '<img id="pics" src="'.$conducteur['profil-picture'].'" alt="Photo de profil" class="photo-profil">';
echo '<p id="cdt-name">'.$conducteur['prenom'].' '.$conducteur['nom'].'</p>';
echo '<p id="trajet">'.$trajet['lieu_depart'].' ➔ '.$trajet['lieu_arrivee'].' | '.$trajet['duree'].'</p>';

$sqls = "SELECT * FROM passager WHERE trajet_id = ?";
$stmts = $dbh->prepare($sqls);
$stmts->bind_param("i", $trajet['id']);
$stmts->execute();
$results = $stmts->get_result();
$num_rows = $results->num_rows;

echo '<p id="place">Place restante :'.$num_rows.'/'.$trajet['place'].'</p>';

if($num_rows == $trajet['place']){
    $complete = 'disabled';
} else {
    $complete = '';
}

?>



            </div>
    


        <?php

        }
    } else {
        echo 'Erreur lors de la récupération du trajet.';
        //afficher une seule fois
        exit();
    }
} 

            } else {
                echo '<p id="none">Aucun trajet n\'a été trouvé</p>';
            }
            ?>
                    </div>

    </div>

      <?php
      if ($trajetInteressant !== null) {

        echo '<div class="tinder--buttons">
          <button id="nope"></button>
          <button id="love"></button>
        </div>
      </div>';

      } else {
        echo '';
      }

      ?>



      <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>




</main>




<?php
require_once('menu.php');

?>

<?php
require_once('footer.php');
?>

<script>
    "use strict";

var tinderContainer = document.querySelector(".tinder");
var allCards = document.querySelectorAll(".tinder--card");
var nope = document.getElementById("nope");
var love = document.getElementById("love");

function initCards(card, index) {
  var newCards = document.querySelectorAll(".tinder--card:not(.removed)");

  newCards.forEach(function (card, index) {
    card.style.zIndex = allCards.length - index;
    card.style.transform =
      "scale(" + (20 - index) / 20 + ") translateY(-" + 30 * index + "px)";
    card.style.opacity = (10 - index) / 10;
  });

  tinderContainer.classList.add("loaded");

}

initCards();

allCards.forEach(function (el) {
  var hammertime = new Hammer(el);

  hammertime.on("pan", function (event) {
    el.classList.add("moving");
  });

  hammertime.on("pan", function (event) {
    if (event.deltaX === 0) return;
    if (event.center.x === 0 && event.center.y === 0) return;

    tinderContainer.classList.toggle("tinder_love", event.deltaX > 0);
    tinderContainer.classList.toggle("tinder_nope", event.deltaX < 0);


    var xMulti = event.deltaX * 0.03;
    var yMulti = event.deltaY / 80;
    var rotate = xMulti * yMulti;

    event.target.style.transform =
      "translate(" +
      event.deltaX +
      "px, " +
      event.deltaY +
      "px) rotate(" +
      rotate +
      "deg)";

  });

  hammertime.on("panend", function (event) {
    el.classList.remove("moving");
    tinderContainer.classList.remove("tinder_love");
    tinderContainer.classList.remove("tinder_nope");

    var moveOutWidth = document.body.clientWidth;
    var keep = Math.abs(event.deltaX) < 80 || Math.abs(event.velocityX) < 0.5;

    event.target.classList.toggle("removed", !keep);
    

    if (keep) {
      event.target.style.transform = "";
    } else {
      var endX = Math.max(
        Math.abs(event.velocityX) * moveOutWidth,
        moveOutWidth
      );
      var toX = event.deltaX > 0 ? endX : -endX;
      var endY = Math.abs(event.velocityY) * moveOutWidth;
      var toY = event.deltaY > 0 ? endY : -endY;
      var xMulti = event.deltaX * 0.03;
      var yMulti = event.deltaY / 80;
      var rotate = xMulti * yMulti;

      event.target.style.transform =
        "translate(" +
        toX +
        "px, " +
        (toY + event.deltaY) +
        "px) rotate(" +
        rotate +
        "deg)";
      initCards();

      if (event.deltaX > 0) {
    var link = event.target.getAttribute('data-link');
    window.location.href = link;
} else {
}



    }
  });
});

function createButtonListener(love) {
  return function (event) {
    var cards = document.querySelectorAll(".tinder--card:not(.removed)");
    var moveOutWidth = document.body.clientWidth * 1.5;

    if (!cards.length) return false;

    var card = cards[0];

    card.classList.add("removed");

    if (love) {
var link = card.getAttribute('data-link');
window.location.href = link;
    
    card.style.transform =
        "translate(" + moveOutWidth + "px, -100px) rotate(-30deg)";
    } else {
      card.style.transform =
        "translate(-" + moveOutWidth + "px, -100px) rotate(30deg)";
    }

    initCards();
    event.preventDefault();
  };
}

var nopeListener = createButtonListener(false);
var loveListener = createButtonListener(true);

nope.addEventListener("click", nopeListener);
love.addEventListener("click", loveListener);


const button = document.getElementById('nope');
const button2= document.getElementById('love');

button.addEventListener('animationend', () => {
  button.blur();
});
button2.addEventListener('animationend', () => {
  button2.blur();
});



</script>