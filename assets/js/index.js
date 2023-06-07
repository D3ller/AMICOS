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
    // -----------------------------

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

// -----------------------------
// SWIPE SCRIPT
// -----------------------------

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


// -----------------------------
// Fin SWIPE SCRIPT
// -----------------------------


const dateInput = document.getElementById('date-input');
const dateText = document.getElementById('date-text');
const calendarIcon = document.getElementById('calendar-icon');

calendarIcon.addEventListener('click', function() {
  dateInput.click();
});

dateText.addEventListener('click', function() {
  dateInput.click();
});

dateInput.addEventListener('change', function() {
  const selectedDate = dateInput.value;
  if (selectedDate !== '') {
    dateText.textContent = selectedDate;
  } else {
    dateText.textContent = 'Quand ?';
  }
});
