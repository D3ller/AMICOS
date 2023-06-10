<?php

session_start();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type='text/css' rel='stylesheet' href='/assets/css/match.css'>
    <link type='text/css' rel='stylesheet' href='/assets/css/header-footer.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

      console.log(event.deltaY);

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
        console.log(love ? "Liked" : "Disliked")
      card.style.transform =
        "translate(" + moveOutWidth + "px, -100px) rotate(-30deg)";
    } else {
        console.log(love ? "Liked" : "Disliked")
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


// Repress
const button = document.getElementById('nope');
const button2= document.getElementById('love');

button.addEventListener('animationend', () => {
  button.blur();
});
button2.addEventListener('animationend', () => {
  button2.blur();
});



</script>