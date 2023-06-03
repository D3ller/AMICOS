<nav>
    <div class="ele-nav">
        <a href='/'>Accueil</a>
        <div class="util-info">
            <?php
require_once './assets/php/lib.php';
        if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMINAME'])){

            $dbh = connect();

            $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
            $stmt = $dbh->prepare($sql);
            $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();    

    echo "<p>Bienvenue ".$user['prenom']."</p>
    <a href='./assets/php/deconnexion.php'>Déconnexion</a>
    <a class='info-con' href='./trajets.php'>Crée un trajet</a>
    <a id='pp' href='./profil.php'><img class='img-profil' src='".$user['profil-picture']."' width='30' height='30'></a>";
        } else {
            // echo "<p>Vous n'êtes pas connecté</p>";
            echo "<a class='info-con' href='./connexion.php'>Connexion</a>";
            echo ' | ';
            echo "<a class='info-con' href='./inscription.php'>Inscription</a>";
            echo ' | ';
            echo "<a class='info-con' href='./forget.php'>Mot de passe oublié</a>";
        }
        ?>
        </div>
    </div>
</nav>

