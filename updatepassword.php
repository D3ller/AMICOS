<?php

session_start();

if(!isset($_SESSION['AMIMAIL']) || !isset($_SESSION['AMIID'])){
    $_SESSION['error'] = "Vous n'êtes pas connecté";
    header('Location: ./index.php');
    exit();
}

require_once './assets/php/lib.php';

$dbh = connect();

$sql = 'SELECT * FROM profil WHERE id = ? AND email = ?';
$stmt = $dbh->prepare($sql);
$stmt->bind_param("is", $_SESSION['AMIID'], $_SESSION['AMIMAIL']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($result->num_rows === 0) {
    header('Location: ../assets/php/deconnexion.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

if(isset($_SESSION['error'])) {
    echo '<p class="error">'.$_SESSION['error'].'</p>';
    unset($_SESSION['error']);
}

?>

<form action="./assets/php/updatepassword.php" method="post">
    
<input name='oldpassword' type='password' id='oldpassword' placeholder='Ancien mot de passe'>
<input name='password' type='password' id='newpassword' placeholder='Nouveau mot de passe'>
<input name='confirmpassword' type='password' id='newpassword2' placeholder='Confirmer le nouveau mot de passe'>

<input type="submit" value="Modifier">
</form>



    
</body>
</html>

