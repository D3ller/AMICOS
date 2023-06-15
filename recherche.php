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
    <link rel="stylesheet" href="./assets/css/recherche.css">
    <link rel="stylesheet" href="./assets/css/header-footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- date -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/js/i18n/fr.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script src="./assets/js/index.js" defer></script>
    <title>Accueil</title>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete&language=fr&output=json&region=FR&key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo" async defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd8vcZ5809PqtE13gop5pdAKe2gRezwGo&libraries=places,geometry&region=FR" async defer></script>
</head>
<body>
    <?php 
    if(isset($_SESSION['error'])) {
        echo '<p class="error">'.$_SESSION['error'].'</p>';
        unset($_SESSION['error']);
    }


    require_once 'customnav.php';

    ?>
<main>



    <div class="form-recherche">

        <button id='reverse' onclick="reverse()"><svg style="margin-top:5px" width="26" height="21" viewBox="0 0 26 21" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M0.227219 13.7978L0.227219 12.2414L1.39455 12.2414L3.72922 14.187C4.63796 14.9442 6.05452 17.6709 6.06385 17.6889L6.06384 0.568115L7.62029 0.568115L7.62029 17.689L7.62033 17.689C7.62033 17.689 9.04326 14.9467 9.955 14.187L12.2897 12.2414L13.457 12.2414L13.457 13.7978C13.457 13.7978 11.9621 14.6503 11.1223 15.3543C9.37554 16.8186 7.62033 20.0236 7.62033 20.0236L7.62029 20.0236L7.62029 20.0237L6.06385 20.0237L6.06385 20.0235C6.05348 20.0046 4.3035 16.8143 2.56189 15.3543C1.72213 14.6503 0.227219 13.7978 0.227219 13.7978Z" fill="black"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M11.8777 6.76964L11.8777 8.32002L13.0405 8.32002L15.3661 6.38205C16.2742 5.62522 17.6916 2.8937 17.6916 2.8937L17.6917 2.8937L17.6917 19.9479L19.2421 19.9479L19.2421 2.8937L19.2421 2.8937C19.2421 2.8937 20.6595 5.62523 21.5677 6.38205L23.8932 8.32002L25.056 8.32002L25.056 6.76964C25.056 6.76964 23.5669 5.92047 22.7305 5.21927C20.9905 3.76067 19.2421 0.568138 19.2421 0.568138L18.4669 0.568138L18.4669 0.56817L18.4668 0.56817L18.4668 0.568136L17.6916 0.568136C17.6916 0.568136 15.9433 3.76067 14.2033 5.21927C13.3668 5.92047 11.8777 6.76964 11.8777 6.76964Z" fill="black"/>
</svg>
</button>
        <form action="/swipe.php" method="post" required>

                    <input type="text" name='depart' id="address" placeholder="Départ" required >
                    <input id='adress2' name='arrivee' type="text" placeholder="Arrivée" required>
                    <!-- <input type="date" name='date' id="date" placeholder="Date" required> -->
                    <input type="text" id="date" placeholder="Date" name="date"/>
                    <script>
                        const myDateInput = document.getElementById('date');
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
                    <select id="place" name='place' min="1" max="7" id="passager" required>
                        <option value="1">1 passager</option>
                        <option value="2">2 passagers</option>
                        <option value="3">3 passagers</option>
                        <option value="4">4 passagers</option>
                        <option value="5">5 passagers</option>
                        <option value="6">6 passagers</option>
                        <option value="7">7 passagers</option>
                    </select>

                    <input name='lat' type="hidden" id="lat" value="" required>
                <input name='lng' type="hidden" id="lng" value="" required>
                <input name='lat2' type="hidden" id="lat2" value="" required>
                <input name='lng2' type="hidden" id="lng2" value="" required>

                    <input id="rechercher-submit" type="submit" value="Voyager !">

        </form>
    </div>

</main>
<?php
    require_once 'footer.php';
    ?>

    <script>
        function reverse() {
            var depart = document.getElementById('address').value;
            var arrivee = document.getElementById('adress2').value;
            document.getElementById('address').value = arrivee;
            document.getElementById('adress2').value = depart;

            var lat = document.getElementById('lat').value;
            var lng = document.getElementById('lng').value;
            var lat2 = document.getElementById('lat2').value;
            var lng2 = document.getElementById('lng2').value;
            document.getElementById('lat').value = lat2;
            document.getElementById('lng').value = lng2;
            document.getElementById('lat2').value = lat;
            document.getElementById('lng2').value = lng;
        }

        </script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
    initAutocomplete();
  });

    </script>
    
</body>
</html>
