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


    <script src="./assets/js/index.js" defer></script>
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

<?php

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){
    $dbh = connect();
    $sql = 'SELECT * FROM profil WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("i", $_SESSION['AMIID']);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();
    echo '<p>Bienvenue '.$user['prenom'].'.</p>';
}

?>
    <main class="main-index">
        <div class="form-index">
            <form action="/assets/php/recherche_trajet.php" method="post" required>
                <div class="haut-form-index">
                    <div class="barre-form-index"></div>
                    <input type="text" name='depart' id="address" placeholder="Départ" required >
                    <input id='adress2' name='arrivee' type="text" placeholder="Arrivée" required>
                </div>
                <div class="bas-form-index">
                    <div class="barre-form-index"></div>
                    <input type="text" id="myDateInput" placeholder="Date" />

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

                <input name='lat' type="hidden" id="lat" value="" required>
                <input name='lng' type="hidden" id="lng" value="" required>

                <input name='lat2' type="hidden" id="lat2" value="" required>
                <input name='lng2' type="hidden" id="lng2" value="" required>

                <input type="submit" value="Voyager !">
            </form>
        </div>

        <!-- Uniquement visible étant connecté -->
        <div class="last-travel">
            <!-- Dernier trajet : (nom du dernier conducteur qui nous à emmené) -->
            <?php 
                $dbh = connect();
                $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
                $stmt = $dbh->prepare($sql);
                $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
                $stmt->execute();
            
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                echo '<h3>Dernier trajet : avec '.$user["prenom"].'</h3>';
            ?>
            <!-- Carte Gmap du dernier trajet -->
            </div>
        </div>

        <!-- Uniquement visible étant connecté -->
        <div class="stats-util">
            <div class="co2">
                <h3>CO2 émit <span class="détail-stats">(en kg)</span></h3>
                <div class="info-stats">
                    <h5>58.8 Kg</h5>
                </div>
            </div>
            <div class="distance">
                <h3>Distance <span class="détail-stats">(en km)</stats></h3>
                <div class="info-stats">
                    <h5>102 Km</h5>
                </div>
            </div>
        </div>

        <!-- Uniquement visible étant connecté -->
        <div class="trajets-inte-util">
            <h3>Des trajets intéréssants pour vous !</h3>

            <img class="carre-card"src="https://portfolio.karibsen.fr/assets/img/carre.svg" alt="">

            <div class="scroll-container">
                <div class="card">
                    <div class="ele-util-card">
                        <a href="reserv/id"><img class="right-arrow" src="https://portfolio.karibsen.fr/assets/img/arrowbuttonright.svg" alt=""></a>
                        <div>
                            <img class="perso" src="https://portfolio.karibsen.fr/assets/img/persorose.svg" alt="">
                            <img class="pp-util" src="https://portfolio.karibsen.fr/assets/img/people.webp" alt="">
                        </div>
                        <h6>Jane Cooper  <span class="exemple-trajet">Troyes ➔ St André</span></h6>
                        <p>Le trajet commencera au parking de l'IUT de Troyes, où vous pourrez facilement garer votre véhicule avant de prendre la route en direction de St André les Vergé. Si vous avez prévu de partir vers 17h, cela vous donnera...</p>
                    </div>
                </div>
                <div class="card">
                    <div class="ele-util-card">
                        <a href="reserv/id"><img class="right-arrow" src="https://portfolio.karibsen.fr/assets/img/arrowbuttonright.svg" alt=""></a>
                        <div>
                            <img class="perso" src="https://portfolio.karibsen.fr/assets/img/persorose.svg" alt="">
                            <img class="pp-util" src="https://portfolio.karibsen.fr/assets/img/people.webp" alt="">
                        </div>
                        <h6>Jane Cooper  <span class="exemple-trajet">Troyes ➔ St André</span></h6>
                        <p>Le trajet commencera au parking de l'IUT de Troyes, où vous pourrez facilement garer votre véhicule avant de prendre la route en direction de St André les Vergé. Si vous avez prévu de partir vers 17h, cela vous donnera...</p>
                    </div>
                </div>
                <div class="card">
                    <div class="ele-util-card">
                        <a href="reserv/id"><img class="right-arrow" src="https://portfolio.karibsen.fr/assets/img/arrowbuttonright.svg" alt=""></a>
                        <div>
                            <img class="perso" src="https://portfolio.karibsen.fr/assets/img/persorose.svg" alt="">
                            <img class="pp-util" src="https://portfolio.karibsen.fr/assets/img/people.webp" alt="">
                        </div>
                        <h6>Jane Cooper  <span class="exemple-trajet">Troyes ➔ St André</span></h6>
                        <p>Le trajet commencera au parking de l'IUT de Troyes, où vous pourrez facilement garer votre véhicule avant de prendre la route en direction de St André les Vergé. Si vous avez prévu de partir vers 17h, cela vous donnera...</p>
                    </div></div>
            </div>

            <!-- Visible tout le temps -->
            <div class="ce-qui-ns-diff">
                <h3>Ce qui nous différencie</h3>

                <div class="cards-ce-qui-ns-diff">
                    <div class="card-cqnd-1">
                        <div class="card-inter-cqnd">
                            <!-- Pin : https://portfolio.karibsen.fr/assets/img/doubleround.svg -->
                            <h6>De meilleures<br>rencontres</h6>
                            <p>
                                Avec Parks, rencontre des personnes 
                                selon vos centre d’intérêts commun. 
                                Grâce à ça, tes voyages seront plus 
                                agréable, pour toi comme pour le 
                                conducteur !
                            </p>
                            <img src="" alt="">
                            <div class="img-cqnd-1-persos img-cqnd"></div>
                        </div>
                    </div>

                    <div class="card-cqnd-2">
                        <div class="card-inter-cqnd">
                            <!-- Pin :  -->
                            <h6>Le respect<br>mis au centre</h6>
                            <p>
                                On a tenu à mettre au centre de notre 
                                site le respect, que ce soit de 
                                l’environnement mais aussi entre 
                                nous et les utilisateurs de Parks. 
                            </p>
                            <div class="img-cqnd-2-persos img-cqnd"></div>
                        </div>
                    </div>

                    <div class="card-cqnd-3">
                        <div class="card-inter-cqnd">
                            <!-- Pin :  -->
                            <h6>L’importance<br>de la sécurité</h6>
                            <p>
                                Avec nous, tu ne roulera jamais avec quelqu’un 
                                que tu connais pas du tout ! Tu seras avec 
                                les autres personnes de ta promo en MMI et 
                                souvent avec tes propres amis !
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
                                C’est aussi ça notre force, faire rencontrer 
                                des personne qui ne se serait jamais 
                                rencontré ! MMI c’est un peut comme 
                                une grande famille finalement ! 
                            </p>
                            <div class="img-cqnd-4-persos img-cqnd"></div>
                            <!-- <img class="img-cqnd-4-persos" src="https://portfolio.karibsen.fr/assets/img/multi.svg" alt=""> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>


</main>

<?php
    require_once 'menu.php';

    require_once 'footer.php';
    ?>
    
</body>
</html>