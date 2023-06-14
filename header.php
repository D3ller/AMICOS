<?php
session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
require_once('./assets/php/lib.php');
?>


<header>
    <!-- PC -->
    <div class="logo-desktop"></div>
    <nav>
        <a class="page-act" href="index.php">Accueil</a>
        <a class="page-act" href="recherche.php">Recherche</a>
        <a class="page-act" href="parkings.php">Parking</a>
    </nav>

    <div class="last-nav-header">
        <?php 
if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])) {
    $dbh = connect();
    $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    echo '<a href="profil.php"><div class="profil-header" style="background-image: url('.$user["profil-picture"].'); border-radius: 50%"></div></a>';    

    echo '<a href="profil.php">Bienvenue test</a>';
} else {
    echo '<a href="connexion.php"><div class="profil-header"></div></a>';
}
?>
        <a href="trajets.php"><div class="plus-header"></div></a>
    </div>


</header>


<script>


function relief() {
  var pageurl = location.href;
  var dnl = document.getElementsByClassName("page-act");
  var pageActive = null; // Variable pour stocker le lien de la page active
  var originalStyles = {}; // Objet pour stocker les styles CSS originaux de la page active

  for (var i = 0; i < dnl.length; i++) {
    var x = dnl.item(i);

    if (x.href === pageurl) {
      // Si le lien correspond à la page active
      pageActive = x; // Mettre à jour le lien de la page active
      originalStyles.color = x.style.color;
      originalStyles.backgroundColor = x.style.backgroundColor;
      originalStyles.borderRadius = x.style.borderRadius;
      originalStyles.border = x.style.border;

      x.style.color = "#ffffff";
      x.style.backgroundColor = "#000000";
      x.style.borderRadius = "1000px";
      x.style.border = "3px solid #000000";
      x.style.transition = "all 0.5s ease-in-out";
    } else {
      x.addEventListener("mouseover", function() {
        if (pageActive) {
          // Réinitialiser les attributs CSS de la page active si un autre lien est survolé
          pageActive.style.color = originalStyles.color;
          pageActive.style.backgroundColor = originalStyles.backgroundColor;
          pageActive.style.borderRadius = originalStyles.borderRadius;
          pageActive.style.border = originalStyles.border;
        }

        // Appliquer les attributs CSS au lien survolé
        this.style.color = "#ffffff";
        this.style.backgroundColor = "#000000";
        this.style.borderRadius = "1000px";
        this.style.border = "3px solid #000000";
        this.style.transition = "all 0.5s ease-in-out";
      });

      x.addEventListener("mouseout", function() {
        if (pageActive) {
          // Réappliquer les attributs CSS à la page active lorsque le lien survolé est quitté
          pageActive.style.color = "#ffffff";
          pageActive.style.backgroundColor = "#000000";
          pageActive.style.borderRadius = "1000px";
          pageActive.style.border = "3px solid #000000";
          pageActive.style.transition = "all 0.5s ease-in-out";
        }

        // Réinitialiser les attributs CSS du lien survolé
        this.style.color = "";
        this.style.backgroundColor = "";
        this.style.borderRadius = "";
        this.style.border = "";
        this.style.transition = "";
      });
    }
  }
}
window.onload = relief;

</script>



