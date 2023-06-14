<?php

session_start();

require_once('./assets/php/lib.php');


?>

<menu>
    <div class="menu">
        <div class="menu__item">
            <a href="index.php">
            <svg width="32" height="28" viewBox="0 0 32 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.39313 10.2616C0.931519 11.4689 0.931519 12.8282 0.931519 15.5466C0.931519 20.4071 0.931519 22.8373 2.08607 24.5897C2.60866 25.383 3.28723 26.0615 4.08046 26.5841C5.68514 27.6413 7.85807 27.7305 11.9447 27.738V18.2219C11.9447 15.7366 13.9648 13.7219 16.4501 13.7219C18.9354 13.7219 20.9555 15.7366 20.9555 18.2219V27.738C25.0422 27.7305 27.2151 27.6413 28.8198 26.5841C29.613 26.0615 30.2916 25.383 30.8142 24.5897C31.9687 22.8373 31.9687 20.4071 31.9687 15.5466C31.9687 12.8282 31.9687 11.4689 31.5071 10.2616C31.2949 9.70654 31.0128 9.18077 30.6678 8.69697C29.9173 7.64462 28.7849 6.89283 26.5201 5.38926L26.5201 5.38925L24.1935 3.84465C20.4393 1.35227 18.5622 0.106079 16.4501 0.106079C14.338 0.106079 12.4609 1.35227 8.70674 3.84465L8.70673 3.84465L6.38016 5.38925C4.11536 6.89282 2.98297 7.64461 2.23244 8.69697C1.88739 9.18077 1.60535 9.70654 1.39313 10.2616Z" fill="black"/>
            </svg>
            </a>
        </div>

        <div class="menu__item">
            <a href="recherche.php">
            <svg width="23" height="28" viewBox="0 0 23 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5611 10.2638C20.5611 13.0356 19.414 15.5394 17.5686 17.3265L22.1985 25.3457C22.4746 25.824 22.3107 26.4356 21.8324 26.7118L20.5597 27.4466C20.0814 27.7227 19.4698 27.5588 19.1937 27.0805L14.6829 19.2676C13.4734 19.7992 12.1365 20.0943 10.7306 20.0943C5.30132 20.0943 0.900024 15.6931 0.900024 10.2638C0.900024 4.83452 5.30132 0.433228 10.7306 0.433228C16.1599 0.433228 20.5611 4.83452 20.5611 10.2638ZM10.7307 16.6248C14.2437 16.6248 17.0916 13.7769 17.0916 10.2638C17.0916 6.75076 14.2437 3.90286 10.7307 3.90286C7.21762 3.90286 4.36973 6.75076 4.36973 10.2638C4.36973 13.7769 7.21762 16.6248 10.7307 16.6248Z" fill="black"/>
            </svg>

            </a>
        </div>

        <div class="menu__item">
            <a href="parkings.php">
            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 28" width="22" height="28"><style></style><path fill-rule="evenodd" d="m21.3 11.1c0 2.6-0.9 5-2.5 6.9l-7.9 9.6-8-9.6c-1.6-1.9-2.5-4.3-2.5-6.9 0-5.9 4.7-10.7 10.5-10.7 5.7 0 10.4 4.8 10.4 10.7zm-6.1-0.4c0-2.4-2-4.4-4.3-4.4-2.4 0-4.4 2-4.4 4.4 0 2.5 2 4.4 4.4 4.4 2.3 0 4.3-1.9 4.3-4.4z"/></svg>
            </a>
        </div>

        <div class="menu__item">
            <!-- Phot de profil à poser en php -->
                <?php

            if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])) {
                $dbh = connect();
                $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
                $stmt = $dbh->prepare($sql);
                $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                echo '<a href="./profil.php">';
                echo '<img src='.$user['profil-picture'].' alt="Photo de profil" class="menu__profil-picture">';
                echo '</a>';
            } else {
                echo '<a href="./connexion.php">';
                        echo '<svg width="23" height="28" viewBox="0 0 26 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12.8315" cy="7.94304" r="7.94304" fill="black"/>
                        <path d="M0 29.9404C0 22.854 5.74467 17.1094 12.8311 17.1094V17.1094C19.9175 17.1094 25.6621 22.854 25.6621 29.9404V33.2491C25.6621 33.7839 25.2286 34.2175 24.6938 34.2175H0.968383C0.43356 34.2175 0 33.7839 0 33.2491V29.9404Z" fill="black"/>
                        </svg>
                    </a>';
            }

            ?>
        </div>
    </div>
</menu>

<?php

//si la page n'est pas la page d'accueil, on affiche pas le menu
if($_SERVER['PHP_SELF'] != '/index.php') {

} else {

    if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])) {
        echo '
<div class="menu__plus">
    <a href="./trajets.php">
    <svg width="61" height="61" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
<ellipse cx="37.5" cy="38.5" rx="34.5" ry="33.5" fill="black"/>
<circle cx="34" cy="34" r="32.5" fill="white" stroke="black" stroke-width="3"/>
<path d="M20.8771 35.3431H32.6569V47.1229C32.6569 47.8646 33.2582 48.4659 33.9999 48.4659C34.7416 48.4659 35.3429 47.8646 35.3429 47.1229V35.3431H47.1227C47.8644 35.3431 48.4657 34.7418 48.4657 34.0001C48.4657 33.2584 47.8644 32.6571 47.1227 32.6571H35.3429V20.8773C35.3429 20.1356 34.7416 19.5343 33.9999 19.5343C33.2582 19.5343 32.6569 20.1356 32.6569 20.8773V32.6571H20.8771C20.1354 32.6571 19.5341 33.2584 19.5341 34.0001C19.5341 34.7418 20.1354 35.3431 20.8771 35.3431Z" fill="black" stroke="black" stroke-width="0.3"/>
<path d="M59.5 11.5L57 9L65.5 21.5H67C66.5 20.5 64.5418 17.5259 63 15.5C61.743 13.8483 59.5 11.5 59.5 11.5Z" fill="black" stroke="black" stroke-width="0.2"/>
<path d="M3 47.5C5.08292 52.9609 11.0938 60.9884 15 63.5L3 47.5Z" fill="black" stroke="black" stroke-width="0.2"/>
</svg>

    </a>    
</div>';
    }
}