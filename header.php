<nav>
    <div class="ele-nav">
        <a href='/'>Accueil</a>
        <div class="util-info">
            <!-- <a href='/inscription.php'>Inscription</a>
            <a href='/connexion.php'>Connexion</a>
            <a href='/admin/admin.php'>Admin</a> -->
            <?php

        if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMINAME'])){
            // echo "<p>Vous êtes connecté</p>";

            $dbh = connect();

            $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
            $stmt = $dbh->prepare($sql);
            $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();    

            echo "<p>Bienvenue ".$user['prenom']."</p>";
            echo "<a href='./assets/php/deconnexion.php'>Déconnexion</a>";
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

