<?php 

session_start();

if(isset($_SESSION['AMIMAIL']) || isset($_SESSION['AMIID'])){
    header('Location: /index.php');
    exit;
}

require_once('./lib.php');

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$groupe = $_POST['group'];
$age = $_POST['age'];
$sexe = $_POST['sexe'];

if(empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($password2) || empty($groupe) || empty($age) || empty($sexe)) {
$_SESSION['error'] = '<div class="errorred">
<div class="errorunderred">
    <div class="errorredcaracter">
    </div>

</div>
<h1>Erreur !</h1>
<p>Un ou plusieurs champs sont vides
</p>
</div>';
header('Location: /inscription.php');
exit();
}

if($password != $password2){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Les mots de passe ne correspondent pas
    </p>
    </div>';
    header('Location: /inscription.php');
    exit();
}

if(strlen($password) < 8){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Le mot de passe doit contenir au moins 8 caractères
    </p>
    </div>';
    header('Location: /inscription.php');
    exit();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>L\'email n\'est pas valide
    </p>
    </div>';
    header('Location: /inscription.php');
    exit();
}

if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}$/', $password)){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial
    </p>
    </div>';
    header('Location: /inscription.php');
    exit();
}

if($groupe != 'A' && $groupe != 'B' && $groupe != 'C' && $groupe != 'D' && $groupe != 'E' && $groupe != 'F' && $groupe != 'Prof'){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Le groupe n\'est pas valide
    </p>
    </div>';
    header('Location: /inscription.php');
    exit();

}

if($sexe != 'Homme' && $sexe != 'Femme' && $sexe != 'Autre'){
    $_SESSION['error'] = '
    <div class="errorred">
        <div class="errorunderred">
            <div class="errorredcaracter">
            </div>
        
        </div>
        <h1>Erreur !</h1>
        <p>Le sexe n\'est pas valide
        </p>
        </div>';
    header('Location: /inscription.php');
    exit();

}

if(!is_numeric($age)){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>L\'age n\'est pas valide
    </p>
    </div>';
    header('Location: /inscription.php');
    exit();

}

if($age < 16 || $age > 85){
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>L\'age n\'est pas valide
    </p>
    </div>';
    header('Location: /inscription.php');
    exit();
}



$password = password_hash($password, PASSWORD_DEFAULT);



$dbh = connect();

$sql = "SELECT * FROM profil WHERE email = '$email'";
$result = $dbh->query($sql);

if($result->num_rows > 0){
    $_SESSION['error'] = "L'email existe déjà";
    header('Location: /inscription.php');
    exit();
}

$description = "Je m\'appelle $prenom $nom et je suis dans le groupe $groupe";

$password = mysqli_real_escape_string($dbh, $password);

$sql = "INSERT INTO profil (email, password, nom, prenom, description, `groups`, age, sexe) VALUES ('$email', '$password', '$nom', '$prenom', '$description', '$groupe', '$age', '$sexe')";

if ($dbh->query($sql) === TRUE) {
    $sql = "SELECT * FROM profil WHERE email = '$email'";
    $result = $dbh->query($sql);
    $user = $result->fetch_assoc();
    $id = $user['id'];
    $_SESSION['error'] = "Votre inscription à réussie!";
    header('Location: /connexion.php');
    exit();

} else {
    $_SESSION['error'] = '<div class="errorred">
    <div class="errorunderred">
        <div class="errorredcaracter">
        </div>
    
    </div>
    <h1>Erreur !</h1>
    <p>Une erreur est survenue
    </p>
    </div>';
    header('Location: /inscription.php');
    exit();
}

$dbh->close();
