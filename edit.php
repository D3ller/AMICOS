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
</head>
<body>

<form action="./assets/php/edit.php" method="post">
  <select id="mySelect" name='pp' required>
    <option value="https://portfolio.karibsen.fr/assets/img/default-pp" data-image="https://portfolio.karibsen.fr/assets/img/default-pp">Avatar rose</option>
    <option value="https://portfolio.karibsen.fr/assets/img/profil-orange" data-image="https://portfolio.karibsen.fr/assets/img/profil-orange">Avatar orange</option>
    <option value="https://portfolio.karibsen.fr/assets/img/vert" data-image="https://portfolio.karibsen.fr/assets/img/vert">Avatar vert</option>
    <option value="https://portfolio.karibsen.fr/assets/img/bleu" data-image="https://portfolio.karibsen.fr/assets/img/bleu">Avatar bleu</option>
  </select>

  <?php 
  
  $dbh = connect();

    $sql = "SELECT * FROM profil WHERE id = ? AND email = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    ?>
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
    <input type="text" name="nom" value="<?php echo $user['nom']; ?>" required>
    <input type="text" name="prenom" value="<?php echo $user['prenom']; ?>" required>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
    <textarea type="text" name="description" required><?php echo $user['description']; ?></textarea>
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
