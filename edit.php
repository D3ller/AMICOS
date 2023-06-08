<?php
session_start();
require_once './assets/php/lib.php';

if(!isset($_SESSION['AMIMAIL']) || !isset($_SESSION['AMIID'])){
    header('Location: ./connexion.php');
    exit();
}

?>


<!DOCTYPE html>
<html>
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <link href='/assets/css/header-footer.css' rel='stylesheet' type='text/css'>
  <link type="text/css" rel="stylesheet" href="/assets/css/profil.css">
</head>
<body>

<?php

require_once('customnav.php');

$dbh = connect();

$sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
$stmt = $dbh->prepare($sql);
$stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<form action="./assets/php/edit.php" method="post" enctype="multipart/form-data">


<div id="profil"><img id="profil-pic" src="https://portfolio.karibsen.fr/assets/img/pp/6481ee5fdec886.21951936.jpg" alt="Photo de profil"><div id="edit-name">    <input type="text" name="nom" value="<?php echo $user['nom']; ?>" required><a href="./edit.php"><div id="edit"></div></a></div><p class="grey">Homme 18 ans</p></div>


  <?php 


  


    ?>
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
    <input type="text" name="prenom" value="<?php echo $user['prenom']; ?>" required>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
    <textarea type="text" name="description" required><?php echo $user['description']; ?></textarea>
    <input type='file' name='image' accept='image/*'>
    <input type="submit" value="Modifier">
</form>

  











  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#mySelect').select2({
        templateResult: function(option) {
          if (!option.id) {
            return option.text;
          }

          var imageUrl = option.element.getAttribute('data-image');
          var optionText = $('<span>' + option.text + '</span>');

          if (imageUrl) {
            var optionImage = $('<img width="50" height="50" style="display: block; margin: 0 auto;" src="' + imageUrl + '">');
            optionText.prepend(optionImage);
          }

          return optionText;
        },
        escapeMarkup: function(markup) {
          return markup;
        }
      });
    });
  </script>
</body>
</html>
