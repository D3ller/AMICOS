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
  <link href='/assets/css/header-footer.css' rel='stylesheet' type='text/css'>
  <link type="text/css" rel="stylesheet" href="/assets/css/profil.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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


<div id="profil">
  <img id="profil-pic" src="<?php echo $user['profil-picture']; ?>" alt="Photo de profil">
  <div id="edit-name">
    <input type="text" name="nom" value="<?php echo $user['nom']; ?>" required>
  </div>
  <p class="grey"><?php echo $user['sexe']. ' '.$user['age']  ?> ans</p>
</div>


  <?php 


  


    ?>
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
    <input type="text" name="prenom" value="<?php echo $user['prenom']; ?>" required>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
    <textarea type="text" name="description" required><?php echo $user['description']; ?></textarea>
    <input type='file' id='imgs' name='image' accept='image/*'>
    <input type="submit" value="Modifier">
</form>

<script>
    const imgs = document.getElementById('imgs');
    const img = document.getElementById('profil-pic');
    imgs.addEventListener('change', (e) => {
        img.src = URL.createObjectURL(e.target.files[0]);
    });
</script>

</body>
</html>
