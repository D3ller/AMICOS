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
    <link type='text/css' rel='stylesheet' href='/assets/css/match.css'>
    <link type='text/css' rel='stylesheet' href='/assets/css/header-footer.css'>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo&libraries=places,geometry&region=FR"></script>
    <title>Match</title>
</head>
<body>

<?php
require_once('customnav.php');
?>
<main>


<div class="tinder">
  <div class="tinder--status">
    <i class="fa fa-remove"></i>
    <i class="fa fa-heart"></i>
  </div>

  <div class="tinder--cards">
  <?php
  $dbh = connect();
  $sql = "SELECT * FROM trajet ORDER BY RAND() LIMIT 10";
  $query = $dbh->prepare($sql);
  $query->execute();
  $result = $query->get_result();
  while ($trajet = $result->fetch_assoc()) {
    $lat = $trajet['lat'];
    $lng = $trajet['lng'];
    $lat2 = $trajet['lat2'];
    $lng2 = $trajet['lng2'];

?>
  <div data-link="https://portfolio.karibsen.fr/reserv/<?php echo $trajet['id'] ?>" class="tinder--card">
    <div class="map-container" style="width: 100%; height: 300px;"></div>
    <h3><?php echo $trajet['lieu_depart']; ?></h3>
    <p><?php echo $trajet['lieu_arrivee']; ?></p>
    <p><?php echo $trajet['conducteur_id']; ?></p>
  </div>
  <script>
    var latDepart = <?php echo $lat; ?>;
    var lngDepart = <?php echo $lng; ?>;
    var latArrivee = <?php echo $lat2; ?>;
    var lngArrivee = <?php echo $lng2; ?>;
  
    function initMap<?php echo $trajet['id']; ?>() {
      var startPoint = new google.maps.LatLng(latDepart, lngDepart);
      var endPoint = new google.maps.LatLng(latArrivee, lngArrivee);
  
      var mapOptions = {
        center: startPoint,
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true,
        mapTypeControl: false,
        mapTypeControlOptions: {
          mapTypeIds: []
        }
      };
  
      var map = new google.maps.Map(document.querySelector('.map-container'), mapOptions);
  
      var directionsService = new google.maps.DirectionsService();
      var directionsRenderer = new google.maps.DirectionsRenderer({
        map: map,
        polylineOptions: {
          strokeColor: "#fe1269"
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
      initMap<?php echo $trajet['id']; ?>();
    };
  </script>
<?php
  }
?>

  </div>
</div>

      
        <div class="tinder--buttons">
          <button id="nope"></button>
          <button id="love"></button>
        </div>
      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>



<?php
require_once('footer.php');
?>
</main>


<?php
require_once('menu.php');
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