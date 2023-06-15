<?php
session_start();
require_once './assets/php/lib.php';

if(!isset($_SESSION['AMIMAIL']) || !isset($_SESSION['AMIID'])){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Vous devez être connecté pour accéder à cette page
    </p>
    </div>';
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
  <style>.cstm{display:flex;}</style>
</head>
<body>

<?php
require_once 'header.php';
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


<div id="profil-mod">
  <img id="profil-pic" src="<?php echo $user['profil-picture']; ?>" alt="Photo de profil">
  <input class="custom-file-input" type='file' id='imgs' name='image' accept='image/*'>
  <div id="edit-name">


    <div class="input-modif">
      <input type="text" name="prenom" value="<?php echo $user['prenom']; ?>" required>
      <label class="label-input-modif">Prénom</label>
    </div>

    <div class="input-modif">
    <input type="text" name="nom" value="<?php echo $user['nom']; ?>" required>
      <label class="label-input-modif">Nom</label>
    </div>

  </div>
  <p class="grey"><?php echo $user['sexe']. ' | '.$user['age']  ?> ans</p>
</div>


  <?php 


    ?>
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

    <div class="input-modif i-mod-2">
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
      <label class="label-input-modif l-i-m-2">E-mail</label>
    </div>

    <div class="input-modif i-mod-2">
      <textarea type="text" name="description" required><?php echo $user['description']; ?></textarea>
      <label class="label-input-modif l-i-m-2">Description</label>
    </div>


    <div class="input-modif i-mod-2">
      <textarea type="text" name="voiture" required><?php echo $user['voiture']; ?></textarea>
      <label class="label-input-modif l-i-m-2">Voiture</label>
    </div>
    
    <!-- <input type="submit" value="Modifier"> -->



    <div class="sub">
      <button type="submit" class="expand">
        Envoyer
        <span class="expand-icon expand-hover">
          <svg class="first" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 32 32" version="1.1">
            <path d="M8.489 31.975c-0.271 0-0.549-0.107-0.757-0.316-0.417-0.417-0.417-1.098 0-1.515l14.258-14.264-14.050-14.050c-0.417-0.417-0.417-1.098 0-1.515s1.098-0.417 1.515 0l14.807 14.807c0.417 0.417 0.417 1.098 0 1.515l-15.015 15.022c-0.208 0.208-0.486 0.316-0.757 0.316z" />
          </svg>
          <span class="loader"></span>
          <svg class="second" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none">
            <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 5L8 15l-5-4" />
          </svg>
        </span>
      </button>
    </div>

    <script>
      document.querySelector("button.expand").addEventListener(
	"click",
	function (e) {
		e.preventDefault();
		e.stopPropagation();
		const button = e.currentTarget;
		button.classList.add("loading");
		button.disabled = true;
		setTimeout(() => {
			button.classList.add("loaded");
			setTimeout(() => {
				button.classList.add("finished");
				setTimeout(() => {
					button.classList.remove("finished");
					button.classList.remove("loaded");
					button.classList.remove("loading");
					button.disabled = false;
          button.closest("form").submit();
				}, 1500);
			}, 700);
		}, 1500);
	},
	false
);

    </script>





</form>

<script>
    const imgs = document.getElementById('imgs');
    const img = document.getElementById('profil-pic');
    imgs.addEventListener('change', (e) => {
        img.src = URL.createObjectURL(e.target.files[0]);
    });

    const buttonedit= document.getElementByClassName('custom-file-input');

    buttonedit.addEventListener('animationend', () => {
      button.blur();
    });
</script>

<?php
require_once 'footer.php';
?>

</body>
</html>
