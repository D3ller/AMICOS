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
    <!-- Input date avec calendar Pikaday pour IOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/js/i18n/fr.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.1/cookieconsent.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.1/cookieconsent.min.css">

    <script src="./assets/js/index.js" defer></script>
    <title>Accueil</title>
    <script defer src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete&language=fr&output=json&region=FR&key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo"></script>

<script defer>
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
</head>
<body>
    <?php 
    require_once 'header.php';
    if(isset($_SESSION['error'])) {
        echo '<p class="error">'.$_SESSION['error'].'</p>';
        unset($_SESSION['error']);
    }
    ?>

    <main class="main-index">
    <?php
if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){
    $dbh = connect();
    $sql = 'SELECT * FROM profil WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("i", $_SESSION['AMIID']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    echo '<p class="bvn">Bienvenue '.$user['prenom'].'.</p>';
}
?>
        <div class="form-index">




            <form action="/swipe.php" method="post">
                <div class="haut-form-index">
                    <div class="barre-form-index"></div>
                    <input type="text" name='depart' id="address" placeholder="Départ" required >
                    <input id='adress2' name='arrivee' type="text" placeholder="Arrivée" required>
                </div>
                <div class="bas-form-index">
                    <div class="barre-form-index"></div>
                    <input type="text" id="myDateInput" placeholder="Date" name="date"/>
                    <script>
                        const myDateInput = document.getElementById('myDateInput');
                        const picker = new Pikaday({
                            field: myDateInput,
                            format: 'DD/MM/YYYY',
                            i18n: {
                                previousMonth: 'Mois précédent',
                                nextMonth: 'Mois suivant',
                                months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                                weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                                weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                                today: 'Aujourd\'hui',
                                clear: 'Effacer',
                                close: 'Fermer'
                            },
                            toString(date) {
                                const day = date.getDate().toString().padStart(2, '0');
                                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                                const year = date.getFullYear().toString();
                                return `${day}/${month}/${year}`;
                            },
                            parse(dateString) {
                                const parts = dateString.split('/');
                                const day = parseInt(parts[0], 10);
                                const month = parseInt(parts[1], 10) - 1;
                                const year = parseInt(parts[2], 10);
                                return new Date(year, month, day);
                            }  
                        });    
                    </script>
                    <input type="number" name='place' placeholder="Nombre de place" min="1" max="7" required>
                </div>
                <input name='lat' type="hidden" id="lat" value="">
                <input name='lng' type="hidden" id="lng" value="">
                <input name='lat2' type="hidden" id="lat2" value="">
                <input name='lng2' type="hidden" id="lng2" value="">
                <input type="submit" value="Voyager !">
            </form>
        </div>

<?php
if (isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])) {

    $sqluser = "SELECT * FROM profil WHERE email = ? AND id = ?";
$stmtuser = $dbh->prepare($sqluser);
$stmtuser->bind_param("ss", $_SESSION['AMIMAIL'], $_SESSION['AMIID']);
$stmtuser->execute();
$resultuser = $stmtuser->get_result();
$user = $resultuser->fetch_assoc();
$n = $resultuser->num_rows;

if($n === 0) {
    exit();
}

$sql = "SELECT trajet.*
FROM passager
INNER JOIN trajet ON passager.trajet_id = trajet.id
WHERE passager.user_id = ? AND trajet.date < NOW()
ORDER BY trajet.date DESC
LIMIT 1";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
$trajet = $result->fetch_assoc();

if($result->num_rows > 0) {
//savoir tout
    echo '
    <div id="banner-travel">
        <div class="last-travel">
            ';

            $sql = "SELECT * FROM profil WHERE id = ?";
            $stmt = $dbh->prepare($sql);
            $stmt->bind_param("i", $trajet['conducteur_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $conducteur = $result->fetch_assoc();

            echo '<h3>Dernier trajet : avec ' . $conducteur["prenom"] . '</h3>';

            echo '
            <div id="map" style="width: 80%; height: 120px; border-radius: 20px; margin: 0 auto;"></div>
        </div>
        <div class="stats-util">
            <div class="co2">
                <h3>CO2 émit <span class="détail-stats">(en kg)</span></h3>
                <div class="info-stats">
                    <h5>'.$trajet["co2"].'kg</h5>
                </div>
            </div>
            <div class="distance">
                <h3>Distance <span class="détail-stats">(en km)</stats></h3>
                <div class="info-stats">
                    <h5>'.$trajet["km"].' Km</h5>
                </div>
            </div>
        </div>
    </div>';

echo "    <script>
var latDepart = $trajet[lat];
var lngDepart = $trajet[lng];
var latArrivee = $trajet[lat2];
var lngArrivee = $trajet[lng2];

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

</script>";

} else {
    
}

$sql = "SELECT trajet.*, COUNT(passager.id) AS nombre_passagers
FROM trajet
LEFT JOIN passager ON trajet.id = passager.trajet_id
WHERE trajet.date > NOW() AND trajet.conducteur_id != ?
GROUP BY trajet.id
HAVING COUNT(passager.id) < trajet.place
ORDER BY RAND()
LIMIT 3;";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
$num_rows = $result->num_rows;

if ($num_rows > 0) {
    echo '<div class="trajets-inte-util">
            <h3>Trajets qui peuvent vous intéresser :</h3>
            <img class="carre-card" src="https://portfolio.karibsen.fr/assets/img/double.svg" alt="">
          <div class="scroll-container">';

        while ($row = $result->fetch_assoc()) {

            $sql = "SELECT * FROM profil WHERE id = ?";
            $stmt = $dbh->prepare($sql);
            $stmt->bind_param("i", $row['conducteur_id']);
            $stmt->execute();
            $result2 = $stmt->get_result();
            $conducteur = $result2->fetch_assoc();

            $row['date'] = date("d/m/Y à H:i", strtotime($row['date']));

            echo '<div class="card">
                    <div class="ele-util-card">
                        <a href="reserv/' . $row['id'] . '"><img class="right-arrow" src="https://portfolio.karibsen.fr/assets/img/flechedroite.svg" alt=""></a>
                        <div>
                            <img class="perso" src="https://portfolio.karibsen.fr/assets/img/persorose.svg" alt="">
                            <img class="pp-util" src="' . $conducteur['profil-picture'] . '" alt="">
                        </div>
                        <h6>Départ le '.$row['date']. '<br>'.$conducteur['prenom'] . ' '. $conducteur["nom"].'<br><span class="exemple-trajet">' . $row["lieu_depart"] . ' ➔ ' . $row["lieu_arrivee"] . '</span></h6>
                        <p>Le trajet commencera au parking de l\'IUT de Troyes, où vous pourrez facilement garer votre véhicule avant de prendre la route en direction de St André les Vergé. Si vous avez prévu de partir vers 17h, cela vous donnera...</p>
                    </div>
                </div>';
            }

        echo '</div>
    </div>';
} else {
}

}
?>
            <!-- Visible tout le temps -->
            <div class="ce-qui-ns-diff">
                <h3>Ce qui nous différencie !</h3>
                <div class="cards-ce-qui-ns-diff">
                    <div class="card-cqnd-1">
                        <div class="card-inter-cqnd">
                            <!-- Pin : https://portfolio.karibsen.fr/assets/img/doubleround.svg -->
                            <h6>De meilleures <br>rencontres</h6>
                            <p class="tt">
                            Parks vous assure des voyages de très haute qualité en 
                            mettant en lien des personnes partageant les mêmes 
                            centres d'intérêt. En renseignant vos préférences et 
                            en complétant votre profil, vous pourrez partager vos 
                            trajets avec des personnes qui vous ressemblent.
                            </p>
                            <div class="img-cqnd-1-persos img-cqnd"></div>
                        </div>
                    </div>

                    <div class="card-cqnd-2">
                        <div class="card-inter-cqnd">
                            <!-- Pin :  -->
                            <h6>Le respect<br>mis au centre</h6>
                            <p>
                            Parks privilégie le respect, tant entre ses 
                            utilisateurs qu'envers l'environnement. Parks 
                            est une plateforme éco-conçue à 98% (selon des 
                            normes strictes) et aide ses utilisateurs 
                            à suivre leurs émissions de CO2.
                            </p>
                            <div class="img-cqnd-2-persos img-cqnd"></div>
                        </div>

                    </div>

                    <div class="card-cqnd-3">
                        <div class="card-inter-cqnd">
                            <!-- Pin :  -->
                            <h6>L’importance<br>de la sécurité</h6>
                            <p>
                            Parks veille à vous assurer des trajets sécurisés. 
                            Tu ne rouleras jamais avec des personnes que tu ne 
                            connais pas ! Grâce aux profils personnalisés, tu 
                            pourras connaître le modèle conduit par ton chauffeur, 
                            son groupe de TP, ainsi que son type de permis et 
                            éventuellement ses années d'expérience.
                            </p>
                            <div class="img-cqnd-3-persos img-cqnd"></div>
                            <!-- <img class="img-cqnd-3-persos" src="https://portfolio.karibsen.fr/assets/img/rouejaune.svg" alt=""> -->
                        </div>

                    </div>
                    <div class="card-cqnd-4">
                        <div class="card-inter-cqnd">
                            <!-- Pin :  -->
                            <h6>Un esprit<br>convivial</h6>
                            <p>
                            Le concept Parks réside dans la solidarité et la 
                            bienveillance de ses utilisateurs. Nous invitons 
                            tous nos utilisateurs à faire preuve de bienséance. 
                            Nous vous souhaitons un agréable voyage.
                            </p>
                            <div class="img-cqnd-4-persos img-cqnd"></div>
                            <!-- <img class="img-cqnd-4-persos" src="https://portfolio.karibsen.fr/assets/img/multi.svg" alt=""> -->
                        </div>

                    </div>
                </div>

            </div>
</main>
<?php
    require_once 'menu.php';
    require_once 'footer.php';
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initAutocomplete();
        });
    </script>

<script>
  window.addEventListener("load", function(){
    window.cookieconsent.initialise({
      "palette": {
        "popup": {
          "background": "#000000"
        },
        "button": {
          "background": "#f1d600"
        }
      },
      "position": "bottom-right",
      "content": {
        "message": "Ce site utilise des cookies pour vous garantir la meilleure expérience. En continuant à naviguer sur ce site, vous acceptez notre utilisation des cookies.",
        "dismiss": "Compris !",
        "link": "En savoir plus",
        "href": "/politique-cookies"
      }
    });
  });
</script>

    
</body>
</html>